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
use Isbn\Isbn;
use ISBNdb\Book as IsbndbBook;

use App\Book;
use App\BookImageSet;
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
        $book->author           = Input::get('author');
        $book->edition          = Input::get('edition');
        $book->num_pages        = Input::get('num_pages');
		$book->binding_id		= Input::get('binding');
		$book->language_id		= Input::get('language');
        $book->save();

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

        return view('product.create', [
			'book' 	=> $book,
			'image' => $image_set
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
		return view("textbook.show", [
			'book' 		=> $book,
			'products'	=> $book->products,
			'image'		=> $book->imageSet
		]);
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
            return view('textbook.result', [
				'book'	=>	$db_book,
				'image' =>	$db_book->imageSet
				]);
        }
        else
        {
			// search book in isbndb
			$token = Config::get('isbndb.token');
			$isbndb_book = new IsbndbBook($token, $isbn);

			if ($isbndb_book->isFound())
			{
				$book = new Book();
				$book->isbn = $isbndb_book->getIsbn13();
				$book->title = $isbndb_book->getTitle();
				$book->author = $isbndb_book->getAuthorName();
				$book->num_pages = $isbndb_book->getNumPages();
				// TODO: language conversion
				// $book->language = $isbndb_book->getLanguage();

				return view('textbook.create')->withBook($book);
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

			return view('textbook.show', [
				'book'	=>	$book,
				'image'	=>	$book->imageSet
				]);
		}
		else
		{
			// TODO: author
			$books = Book::where('title', 'LIKE', "%$info%")->get();

			return view('textbook.list')->withBooks($books);
		}
	}
}