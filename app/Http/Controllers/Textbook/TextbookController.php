<?php namespace App\Http\Controllers\Textbook;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Auth;
use Input;
use Config;
use App\Helpers\FileUploader;
use App\Helpers\SearchClassifier;
use App\Helpers\AmazonLookUp;
use Isbn\Isbn;

use App\Book;
use App\BookImageSet;
use App\BookAuthor;
use App\Product;
use App\ProductContion;

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
        return view('textbook.create');
    }

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		// create book
        $book = new Book();
        $book->isbn             = Input::get('isbn');
        $book->title            = Input::get('title');
        $book->edition          = Input::get('edition');
        $book->num_pages        = Input::get('num_pages');
		$book->binding_id		= Input::get('binding');
		$book->language_id		= Input::get('language');
        $book->save();

		// create book authors
		$authors_str = Input::get('authors');
		$authors_array = explode(',', $authors_str);

		foreach ($authors_array as $author) {
			$book_author = new BookAuthor();
			$book_author->book_id = $book->id;
			$book_author->full_name = trim($author);
		}

		// create book image set
		if (Input::hasFile('image'))
		{
			if (!Input::file('image')->isValid())
			{
				return response('Please upload a valid image.');
			}

			// get the uploaded file
			$image = Input::file('image');
			$title = Input::get('title');
			$folder = '/img/book/';
			$file_uploader = new FileUploader($image, $title, $folder);
		}
		else
		{
			return response('Please upload a textbook image.');
		}

		$image_set = new BookImageSet();
		$image_set->book_id = $book->id;
		$image_set->large_image = $file_uploader->getPath();
		$image_set->save();

		// save the book image
		$file_uploader->saveFile();

        return view('product.create')->withBook($book);
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
    public function isbnSearch(Request $request)
    {
        $isbn = Input::get('isbn');
		$isbn_validator = new Isbn();

		// check if the input is a valid ISBN
		if ($isbn_validator->validation->isbn($isbn) == false)
		{
            return redirect('textbook/sell')->with('message', 'Please enter a valid 10 or 13 digit ISBN number.');
		}

		// if the input ISBN is 10 digits, convert it to 13 digits
		if (strlen($isbn) == 10)
		{
			$isbn = $isbn_validator->translate->to13($isbn);
		}

        $db_book = Book::where('isbn', '=', $isbn)->first();

        // if the book is in our db, show the book information and let seller edit it
        if ($db_book)
        {
            return view('textbook.result')->withBook($db_book);
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

				return view('textbook.result')->withBook($book);
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

		$classifier = new SearchClassifier($info);

		// if ISBN, return the specific textbook page
		if ($classifier->isIsbn())
		{
			$book = Book::where('isbn', $info)->first();

            return view('textbook.show')->withBook($book);
		}
		else
		{
			// TODO: author
			$books = Book::where('title', 'LIKE', "%$info%")->get();

			return view('textbook.list')->withBooks($books);
		}
	}
}
