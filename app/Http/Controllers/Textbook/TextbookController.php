<?php namespace App\Http\Controllers\Textbook;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Book;
use App\BookAuthor;
use App\BookImageSet;
use App\Helpers\FileUploader;
use Isbn\Isbn;
use GoogleBooks\GoogleBooks;

use Auth;
use Config;
use Input;
use Validator;
use DB;
use Response;

class TextbookController extends Controller
{

    /**
     * Display the textbook buy page.
     *
     * @return Response
     */
    public function index()
    {
        return redirect('textbook/buy');
    }

    /**
     * Display a specified textbook.
     *
     * @param $book
     *
     * @return mixed
     */
    public function show($book)
    {
        return view("textbook.show")
            ->with('book', $book);
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
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sellSearch(Request $request)
    {
        $isbn_validator = new Isbn();

        // remove isbn hyphens
        $isbn = $isbn_validator->hyphens->removeHyphens(Input::get('isbn'));

        // check if the input is a valid ISBN
        if ($isbn_validator->validation->isbn($isbn) == false)
        {
            return redirect()->back()
                ->withMessage('Please enter a valid 10 or 13 digit ISBN number.');
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
            return redirect('textbook/sell/product/' . $db_book->id . '/create');
        }
        else
        {
            // Amazon lookup
//            $amazon = new AmazonLookUp($isbn, 'ISBN');

            $google_book = new GoogleBooks(Config::get('services.google.books.api_key'));

            if ($google_book->searchByISBN($isbn))
            {
                $book = $this->createBookByGoogleBooks($google_book);

                return redirect('textbook/sell/product/' . $book->id . '/create');
            }

            // allow the seller fill in book information and create a new book record
            return redirect('textbook/sell/create')
                ->with('message', 'Looks like your textbook is currently not in our database, please fill in the textbook information below.');
        }
    }

    /**
     * Create a book according to the data from Amazon API.
     *
     * @param $google_book
     *
     * @return Book
     */
    protected function createBookByGoogleBooks($google_book)
    {
        // save this book to our database
        $book = Book::create([
            'isbn10'    => $google_book->getIsbn10(),
            'isbn13'    => $google_book->getIsbn13(),
            'title'     => $google_book->getTitle(),
            'language'  => $google_book->getLanguage(),
            'num_pages' => $google_book->getPageCount(),
        ]);

        // save book image set
        BookImageSet::create([
            'book_id'       => $book->id,
            'small_image'   => $google_book->getThumbnail(),
            'medium_image'  => $google_book->getThumbnail(),
            'large_image'   => $google_book->getThumbnail()
        ]);

        // save book authors
        foreach ($google_book->getAuthors() as $author_name) {
            BookAuthor::create([
                'book_id'   => $book->id,
                'full_name' => $author_name
            ]);
        }

        return $book;
    }

    /**
     * Show the form for creating a new textbook.
     *
     * @return Response
     */
    public function create()
    {
        return view('textbook.create');
    }

    /**
     * Store a newly created book in storage.
     * Only if the input ISBN is not in our database and amazon database.
     *
     * @param $authors_arr
     * @return Response
     */
    public function store($authors_arr)
    {
        // validation
        $v = Validator::make(Input::all(), Book::rules());
        $isbn = Input::get('isbn');

        $v->after(function ($v) use ($isbn)
        {
            $isbn_validator = new Isbn();

            if ($v->errors()->has('isbn') == false)
            {
                // check if the input ISBN is valid
                if ($isbn_validator->validation->isbn($isbn) == false)
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

        $isbn_validator = new Isbn();

        if (strlen($isbn) == 10)
        {
            $isbn10 = $isbn;
            $isbn13 = $isbn_validator->translate->to13($isbn);
        }
        else
        {
            $isbn13 = $isbn;
            $isbn10 = $isbn_validator->translate->to10($isbn);
        }

        // create book
        $book = Book::create([
            'title'     => Input::get('title'),
            'edition'   => Input::get('edition'),
            'num_pages' => Input::get('num_pages'),
            'binding'   => Input::get('binding'),
            'language'  => Input::get('language'),
            'isbn10'    => $isbn10,
            'isbn13'    => $isbn13,
        ]);

        // create book authors
        $authors_str = Input::get('authors');
        $authors_arr = explode(',', $authors_str);
        foreach ($authors_arr as $author)
        {
            $book_author = BookAuthor::create([
                'book_id'   => $book->id,
                'full_name' => trim($author),
            ]);
        }

        // create book image set
        $image = Input::file('image');
        $title = Input::get('title');
        $folder = Config::get('upload.image.book');
        $file_uploader = new FileUploader($image, $title, $folder, $book->id);
        $file_uploader->saveBookImageSet();

        return view('product.create')
            ->with('book', $book);
    }

    /***************************************************/
    /******************   Buy Part   *******************/
    /***************************************************/

    /**
     * Show the textbook buy page.
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
        $query = Input::get('query');
        $isbn_validator = new Isbn();

        // if ISBN, return the specific textbook page
        if ($isbn_validator->validation->isbn($query))
        {
            $isbn = $isbn_validator->hyphens->removeHyphens($query);

            if (strlen($isbn) == 10)
            {
                $book = Book::where('isbn10', '=', $isbn)->first();
            }
            else
            {
                $book = Book::where('isbn13', '=', $isbn)->first();
            }

            return view('textbook.show')
                ->withBook($book);
        }
        else
        {
            if (Auth::check())
            {
                // if the user is logged in, search books by the user's university id
                $books = Book::queryWithBuyerID($query, Auth::user()->id);
            }
            else
            {
                // guest user, search books by the university id selected by the user
                $university_id = Input::get('university_id');
                $books = Book::queryWithUniversityID($query, $university_id);
            }

            // Get current page form url e.g. &page=1
            $currentPage = LengthAwarePaginator::resolveCurrentPage();

            // Define how many items we want to be visible in each page
            $perPage = Config::get('pagination.limit.textbook');

            // Slice the collection to get the items to display in current page
            $currentPageSearchResults = $books->slice(($currentPage - 1) * $perPage, $perPage)->all();

            // Create our paginator and pass it to the view
            $paginatedSearchResults= new LengthAwarePaginator($currentPageSearchResults, count($books), $perPage);

            // Set paginator uri
            $paginatedSearchResults->setPath('');

            return view('textbook.list')
                ->with('books', $paginatedSearchResults)
                ->with('query', $query);
        }
    }

    /**
     * Search AutoComplete for the buy page.
     * Return book data in JSON format.
     *
     * @return JSON Response
     */
    public function buySearchAutoComplete()
    {
        $query = Input::get('term');

        if (Auth::check())
        {
            // if the user is logged in, search books by the user's university id
            $books = Book::queryWithBuyerID($query, Auth::user()->id);
        }
        else
        {
            // guest user, search books by the university id selected by the user
            $university_id = Input::get('university_id');
            $books = Book::queryWithUniversityID($query, $university_id);
        }

        $book_data = array();

        foreach ($books as $book)
        {
            $authors = array();

            foreach ($book->authors as $author)
            {
                array_push($authors, $author->full_name);
            }

            $book_image = null;

            if ($book->imageSet && $book->imageSet->small_image)
            {
                $book_image = $book->imageSet->small_image;
            }

            $book_data[] = [
                'id'      => $book->id,
                'title'   => $book->title,
                'isbn10'  => $book->isbn10,
                'isbn13'  => $book->isbn13,
                'authors' => $authors,
                'image'   => $book_image
            ];

        }

        return Response::json($book_data);
    }

}
