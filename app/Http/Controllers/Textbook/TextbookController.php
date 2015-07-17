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
use Illuminate\Pagination\Paginator;
use Input;
use Isbn\Isbn;
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

    /**
     * Display a specified textbook with available products.
     *
     * @param $book
     *
     * @return mixed
     */
    public function show($book)
    {
        $available_products = $book->availableProducts(Auth::user()->id);

        return view("textbook.show")
            ->with('book', $book)
            ->with('available_products', $available_products);
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
            $amazon = new AmazonLookUp($isbn, 'ISBN');

            if ($amazon->success())
            {
                // save book
                $book = Book::create([
                    'isbn10'            => $amazon->getISBN10(),
                    'isbn13'            => $amazon->getISBN13(),
                    'title'             => $amazon->getTitle(),
                    'edition'           => $amazon->getEdition(),
                    'binding'           => $amazon->getBinding(),
                    'language'          => $amazon->getLanguage(),
                    'num_pages'         => $amazon->getNumPages(),
                    'list_price'        => $amazon->getListPriceDecimalPrice(),
                    'lowest_new_price'  => $amazon->getLowestNewPriceDecimalPrice(),
                    'lowest_used_price' => $amazon->getLowestUsedriceDecimalPrice()
                ]);

                // save book image set
                $book_image_set = BookImageSet::create([
                    'book_id'      => $book->id,
                    'small_image'  => $amazon->getSmallImage(),
                    'medium_image' => $amazon->getMediumImage(),
                    'large_image'  => $amazon->getSmallImage(),
                ]);

                // save book authors
                foreach ($amazon->getAuthors() as $author_name)
                {
                    $book_author = BookAuthor::create([
                        'book_id'   => $book->id,
                        'full_name' => $author_name,
                    ]);
                }

                return redirect('textbook/sell/product/' . $book->id . '/create');
            }

            // allow the seller fill in book information and create a new book record
            return redirect('textbook/sell/create')
                ->with('message', 'Looks like your textbook is currently not in our database, please fill in the textbook information below.');
        }
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
            // search by title
//            $books = Book::where('title', 'LIKE', "%$query%")
//                ->paginate(Config::get('pagination.limit.textbook'));

            // TODO: pagination
            // select all books that can be delivered to buyer's university
            $results = DB::select('
                SELECT DISTINCT(books.id)
                FROM books, products, users as seller
                WHERE books.id = products.book_id
                AND products.seller_id = seller.id
                AND seller.university_id IN (
                    SELECT uu.from_uid
                    FROM users as buyer, university_university as uu
                    WHERE buyer.id = ?
                    AND buyer.university_id = uu.to_uid
                )
                AND seller.university_id IN (
                    SELECT id
                    FROM universities
                    WHERE is_public = TRUE
                )
                AND books.title LIKE ?
            ', [Auth::user()->id, '%'.$query.'%']);

            $books = array();

            foreach ($results as $result)
            {
                array_push($books, Book::find($result->id));
            }

            return view('textbook.list')
                ->with('books', $books)
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
        $term = Input::get('term');
        $books = Book::where('title', 'LIKE', '%' . $term . '%')->take(10)->get();

        $book_data = array();

        foreach ($books as $book)
        {
            $authors = array();

            foreach ($book->authors as $author)
            {
                array_push($authors, $author->full_name);
            }

            $book_data[] = [
                'id'      => $book->id,
                'title'   => $book->title,
                'isbn10'  => $book->isbn10,
                'isbn13'  => $book->isbn13,
                'authors' => $authors,
                'image'   => $book->imageSet->small_image
            ];
        }

        return Response::json($book_data);
    }
}
