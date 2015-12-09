<?php namespace App\Http\Controllers\Textbook;

use App\Book;
use App\BookAuthor;
use App\BookImageSet;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\University;
use Auth;
use Aws\Laravel\AwsFacade;
use Aws\S3\Exception\S3Exception;
use DB;
use GoogleBooks\GoogleBooks;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Input;
use Isbn\Isbn;
use Response;
use Validator;

class TextbookController extends Controller
{

    /**
     * Display the textbook buy page.
     *
     * @return Response
     */
    public function index()
    {
        return redirect('/');
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
        $order = Input::get('order');
        $university_id = Input::get('university_id');

        // if no $university_id in query but we have the user logged in
        // apply $university_id with user's university_id
        if (!$university_id && Auth::check())
        {
            $university_id = Auth::user()->university->id;
        }

        // prepare query for products
        $query = $book->products()
            ->where('verified', true)
            ->where('sold', false)
            ->whereNull('deleted_at');

        // if the query contains $university_id, filter the product by
        // university id
        if ($university_id && trim($university_id) != '')
        {
            $query = $query
                ->join('users as seller', 'seller.id', '=', 'products.seller_id')
                ->whereIn('seller.university_id', function ($q) use ($university_id) {
                    $q->select('from_uid')->distinct()
                        ->from('university_university')
                        ->where('to_uid', '=', $university_id);
                });
        }

        // order the products by different types
        if ($order == 'price')
        {
            $products = $query
                ->orderBy('price')
                ->get();
        }
        elseif ($order == 'condition')
        {
            $products = $query
                ->join('product_conditions as cond', 'products.id', '=', 'cond.product_id')
                ->orderBy('cond.general_condition')
                ->select('products.*')
                ->get();
        }
        else
        {
            $products = $query
                ->join('product_conditions as cond', 'products.id', '=', 'cond.product_id')
                ->orderBy('cond.general_condition')
                ->select('products.*')
                ->get();
        }

        return view("textbook.show")
            ->with('book', $book)
            ->with('products', $products)
            ->with('query', Input::get('query'))
            ->with('order', $order)
            ->with('university_id', $university_id)
            ->with('universities', University::availableUniversities());
    }

    /**
     * Search for a textbook by ISBN, title or author.
     *
     * @return $this
     */
    public function search()
    {
        $query = Input::get('query');
        $isbn_validator = new Isbn();

        // if ISBN, return the specific textbook page
        if ($isbn_validator->validation->isbn($query))
        {
            $isbn = $isbn_validator->hyphens->removeHyphens($query);

            if (strlen($isbn) == 10)
            {
                $book = Book::where('isbn10', '=', $isbn)
                    ->where('is_verified', true)
                    ->first();
            }
            else
            {
                $book = Book::where('isbn13', '=', $isbn)
                    ->where('is_verified', true)
                    ->first();
            }

            // if book is in the database
            if ($book)
            {
                return redirect('textbook/confirm/'.$book->id)
                    ->with('book', $book);
            }
            else
            {
                $google_book = new GoogleBooks(config('services.google.books.api_key'));

                // error on searching (e.g. item not found)
                if (!$google_book->searchByISBN($isbn))
                {
                    return view('textbook.list')
                        ->with('books', [])
                        ->with('query', $isbn);
                }

                $book = Book::createFromGoogleBook($google_book);

                if ($book)
                {
                    return redirect('textbook/confirm/'.$book->id)
                        ->with('book', $book)
                        ->with('query', $query);
                }
                else
                {
                    return redirect()->back()
                        ->with('info', 'An error occured. Please try again.');
                }

            }
        }
        else
        {
            $books = Book::searchByQuery($query);

            // Get current page form url e.g. &page=1
            if (Input::has('page'))
            {
                $currentPage = LengthAwarePaginator::resolveCurrentPage() - 1;
            }
            else
            {
                $currentPage = 0;
            }

            // Define how many items we want to be visible in each page
            $perPage = config('pagination.limit.textbook');

            // Slice the collection to get the items to display in current page
            $currentPageSearchResults = $books->slice(($currentPage) * $perPage, $perPage)->all();

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
     * Textbook confirm page.
     *
     * @param $book
     * @return $this
     */
    public function confirm($book)
    {
        return view('textbook.confirm')
            ->with('book', $book);
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
     * @return Response
     */
    public function store()
    {
        $image = Input::file('image');

        // validation
        $v = Validator::make(Input::all(), Book::rules($image));
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

                // check if the ISBN already exists
                if (strlen($isbn) == 10)
                {
                    if (Book::where('isbn10', $isbn)->count() > 0)
                    {
                        $v->errors()->add('isbn', 'The ISBN already exists.');
                    }
                }
                else
                {
                    if (Book::where('isbn13', $isbn)->count() > 0)
                    {
                        $v->errors()->add('isbn', 'The ISBN already exists.');
                    }
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
        $book_image = new BookImageSet();
        $book_image->book_id = $book->id;
        $book_image->save();

        // save product image paths with different sizes
        $book_image->update([
            'small_image'   => $book_image->generateFilename('small', $image),
            'medium_image'  => $book_image->generateFilename('medium', $image),
            'large_image'   => $book_image->generateFilename('large', $image)
        ]);

        $book_image->resize($image);
        $book_image->uploadToAWS();

        return redirect('/textbook/sell/product/' . $book->id . '/create')
            ->with('book', $book);
    }

    /**
     * Search AutoComplete.
     * Return books data in JSON format.
     *
     * @return JSON Response
     */
    public function searchAutoComplete()
    {
        $query = Input::get('term');
        $books = Book::searchByQuery($query, 5);
        $book_data = array();

        foreach ($books as $book)
        {
            $book_data[] = [
                'id'      => $book->id,
                'title'   => $book->title,
                'isbn10'  => $book->isbn10,
                'isbn13'  => $book->isbn13,
                'authors' => $book->getAuthorsNames(),
                'image'   => $book->imageSet->getImagePath('small'),
            ];
        }

        return Response::json($book_data);
    }

    /**
     * AJAX: validate ISBN.
     *
     * @return mixed
     */
    public function validateISBN()
    {
        $query = Input::get('isbn');
        $isbn_validator = new Isbn();

        if ($isbn_validator->validation->isbn($query))
        {
            return Response::json([
                'valid' => true
            ]);
        }
        else
        {
            return Response::json([
                'valid'     => false
            ]);
        }
    }

}
