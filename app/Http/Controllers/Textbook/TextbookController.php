<?php namespace App\Http\Controllers\Textbook;

use App\Book;
use App\BookAuthor;
use App\BookImageSet;
use App\Helpers\AmazonLookUp;
use App\Helpers\FileUploader;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Auth;
use Config;
use Illuminate\Http\Request;
use Input;
use Isbn\Isbn;
use Validator;
use DB;
use Response;

class TextbookController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return redirect('textbook/buy');
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
            $isbn_validator = new Isbn();

            if ($v->errors()->has('isbn') == false)
            {
                // check if the input ISBN is valid
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

        $isbn = Input::get('isbn');
        $isbn_validator = new Isbn();

		// create book
        $book = new Book();

        if (strlen($isbn) == 10)
        {
            $book->isbn10 = $isbn;
            $book->isbn13 = $isbn_validator->translate->to13($isbn);
        }
        else
        {
            $book->isbn13 = $isbn;
            $book->isbn10 = $isbn_validator->translate->to10($isbn);
        }

        $book->title        = Input::get('title');
        $book->edition      = Input::get('edition');
        $book->num_pages    = Input::get('num_pages');
		$book->binding		= Input::get('binding');
		$book->language		= Input::get('language');
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
     * Search function for the sell page.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sellSearch(Request $request)
    {
		$isbn_validator = new Isbn();
        $isbn = $isbn_validator->hyphens->removeHyphens(Input::get('isbn'));

		// check if the input is a valid ISBN
		if ($isbn_validator->validation->isbn($isbn) == false)
		{
            return redirect()->back()->withMessage('Please enter a valid 10 or 13 digit ISBN number.');
		}

        // database lookup
		if (strlen($isbn) == 10)
		{
            $db_book = Book::where('isbn10', '=', $isbn)->first();
		}
        else
        {
            $db_book = Book::where('isbn13', '=', $isbn)->first();
        }

        // book found in database
        if ($db_book)
        {
            return redirect('textbook/sell/product/create/'.$db_book->id);
        }
        else
        {
			// Amazon lookup
			$amazon = new AmazonLookUp($isbn, 'ISBN');

			if ($amazon->success())
			{
				// save book
				$book = new Book();
				$book->isbn10 = $amazon->getISBN10();
                $book->isbn13 = $amazon->getISBN13();
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
            $isbn = $isbn_validator->hyphens->removeHyphens($info);
            if (strlen($isbn) == 10)
            {
                $book = Book::where('isbn10', '=', $isbn)->first();
            }
            else
            {
                $book = Book::where('isbn13', '=', $isbn)->first();
            }

			return view('textbook.show')->withBook($book);
		}
		else
		{
			$books = Book::where('title', 'LIKE', "%$info%")->get();
            return view('textbook.list')->withBooks($books)->withInfo($info);
		}
	}

    /**
     * Search AutoComplete for the buy page.
     * Return book data in JSON format.
     *
     * @return JSON
     */
    public function buySearchAutoComplete()
    {
        $term = Input::get('term');

        $results = array();

        $books = Book::where('title', 'LIKE', '%'.$term.'%')->take(10)->get();

        foreach ($books as $book)
        {
            $authors = array();

            foreach ($book->authors as $author)
            {
                array_push($authors, $author->full_name);
            }

            $results[] = [
                'id'        => $book->id,
                'title'     => $book->title,
                'isbn10'    => $book->isbn10,
                'isbn13'    => $book->isbn13,
                'authors'   => $authors,
                'image'     => $book->imageSet->small_image
            ];
        }

        return Response::json($results);
    }
}
