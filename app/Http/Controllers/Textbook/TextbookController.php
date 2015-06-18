<?php namespace App\Http\Controllers\Textbook;

use App\Book;
use App\BookAuthor;
use App\BookImageSet;
use App\Helpers\AmazonLookUp;
use App\Helpers\FileUploader;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\ProductContion;
use Auth;
use Config;
use Illuminate\Http\Request;
use Input;
use Isbn\Isbn;
use Validator;

class TextbookController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('textbook.buy');
	}

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('textbook.create', [
            'bindings'   => Config::get('book.bindings'),
            'languages'  => Config::get('book.languages')
        ]);
    }

	/**
	 * Store a newly created book in storage.
     * Only if the input ISBN is not in our database and amazon database.
	 *
	 * @return Response
	 */
	public function store()
	{
        // validation
        $v = Validator::make(Input::all(), [
            'isbn'      =>  'required|unique:books',
            'title'     =>  'required|string',
            'authors'   =>  'required|string',
            'edition'   =>  'required|integer',
            'num_pages' =>  'required|integer',
            'binding'   =>  'required|string',
            'language'  =>  'required|string',
            'image'     =>  'required|mimes:jpeg,png'
        ]);

        $v->after(function($v)
        {
            // check if the input ISBN is valid
            $isbn_validator = new Isbn();

            if ($v->errors()->has('isbn') == false)
            {
                if ($isbn_validator->validation->isbn(Input::get('isbn')) == false)
                {
                    $v->errors()->add('isbn', 'Please enter a valid 10 or 13 digit ISBN number.');
                }
            }

        });

        if ($v->fails())
        {
            return redirect()->back()
                ->withErrors($v->errors())
                ->withInput(Input::all());
        }

		// create book
        $book = new Book();
        $book->isbn             = Input::get('isbn');
        $book->title            = Input::get('title');
        $book->edition          = Input::get('edition');
        $book->num_pages        = Input::get('num_pages');
		$book->binding		    = Input::get('binding');
		$book->language		    = Input::get('language');
        $book->save();

		// create book authors
		$authors_str = Input::get('authors');
		$authors_array = explode(',', $authors_str);

		foreach ($authors_array as $author) {
			$book_author = new BookAuthor();
			$book_author->book_id = $book->id;
			$book_author->full_name = trim($author);
            $book_author->save();
		}

		// create book image set
        $image = Input::file('image');
        $title = Input::get('title');
        $folder = Config::get('upload.image.book');
        $file_uploader = new FileUploader($image, $title, $folder, $book->id);
        $file_uploader->saveBookImageSet();


        return view('product.create', [
            'book'  =>  $book,
            'conditions' =>  Config::get('product.conditions')
        ]);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($book)
	{
		return view("textbook.show")->withBook($book);
	}


    /***************************************************/
    /******************   Sell Part   ******************/
    /***************************************************/

    /**
     * Show the sell page, which is a search box of isbn.
     *
     * @return Response
     */
    public function sell()
    {
        return view('textbook.sell');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sellSearch(Request $request)
    {
        $isbn = Input::get('isbn');
		$isbn_validator = new Isbn();

		// check if the input is a valid ISBN
		if ($isbn_validator->validation->isbn($isbn) == false)
		{
            return redirect()->back()->withMessage('Please enter a valid 10 or 13 digit ISBN number.');
		}

		// if the input ISBN is 10 digits, convert it to 13 digits
		if (strlen($isbn) == 10)
		{
			$isbn = $isbn_validator->translate->to13($isbn);
		}

        // if the book is in our db, show the book information
        $db_book = Book::where('isbn', '=', $isbn)->first();

        if ($db_book)
        {
            return redirect('textbook/sell/product/create/'.$db_book->id);
        }
        else
        {
			// search book using Amazon API
			$amazon = new AmazonLookUp($isbn, 'ISBN');

			if ($amazon->success())
			{
				// save this book to our database
				$book = new Book();
				$book->isbn = $isbn;
				$book->title = $amazon->getTitle();
				$book->edition = $amazon->getEdition();
				$book->binding = $amazon->getBinding();
				$book->language = $amazon->getLanguage();
				$book->num_pages = $amazon->getNumPages();
				$book->save();

				// save book image set
				$book_image_set = new BookImageSet();
				$book_image_set->book_id = $book->id;
				$book_image_set->small_image = $amazon->getSmallImage();
				$book_image_set->medium_image = $amazon->getMediumImage();
				$book_image_set->large_image = $amazon->getLargeImage();
				$book_image_set->save();

				// save book authors
				foreach ($amazon->getAuthors() as $author_name) {
					$book_author = new BookAuthor();
					$book_author->book_id = $book->id;
					$book_author->full_name = $author_name;
					$book_author->save();
				}

				return redirect('textbook/sell/product/create/'.$book->id);
			}

			// allow the seller fill in book information and create a new book record
            return redirect('textbook/sell/create')->with(
                'message',
                'Looks like your textbook is currently not in our database, please fill in the textbook information below.');
        }
    }

    /***************************************************/
    /******************   Buy Part   *******************/
    /***************************************************/

    /**
     * Show the buy page.
     *
     * @return Response
     */
    public function showBuyPage()
    {
        return view('textbook.buy');
    }

	/**
     * Search function for the buy page.
     *
     * @return Response
     */
	public function buySearch()
	{
		$info = Input::get('info');
        $isbn_validator = new Isbn();

		// if ISBN, return the specific textbook page
		if ($isbn_validator->validation->isbn($info))
		{
			$book = Book::where('isbn', '=', $info)->first();
			return view('textbook.show')->withBook($book);
		}
		else
		{
			// TODO: author
			$books = Book::where('title', 'LIKE', "%$info%")->get();
            return view('textbook.list')->withBooks($books)->withInfo($info);
		}
	}
}
