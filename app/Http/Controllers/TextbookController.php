<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Auth;
use Input;

use App\Book;
use App\BookImageSet;
use App\BookBinding;
use App\BookLanguage;
use Illuminate\Support\Facades\DB;

use App\Helpers\FileUploader;


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
        // validations could be done in Validation class
        if (Input::hasFile('image'))
        {
            if (!Input::file('image')->isValid())
            {
                return response('Please upload a valid image.');
            }

            // get the uploaded file
            $image = Input::file('image');
			$title = Input::get('title');
			$folder = '/img/';
			$file_uploader = new FileUploader($image, $title, $folder);
        }
        else
        {
            return response('Please upload a textbook image.');
        }

        $image_set = new BookImageSet();
        $image_set->large_image = $file_uploader->path;
        $image_set->save();

        // TODO: upload book information for verification
        $book = new Book();
        $book->isbn             = Input::get('isbn');
        $book->title            = Input::get('title');
        $book->author           = Input::get('author');
        $book->edition          = Input::get('edition');
        $book->publisher        = Input::get('publisher');
        $book->publication_date = Input::get('publication_date');
        $book->manufacturer     = Input::get('manufacturer');
        $book->num_pages        = Input::get('num_pages');
        $book->binding_id       = Input::get('binding');
        $book->image_set_id     = $image_set->id;
        $book->language_id      = Input::get('language');

        // save the book image
		$file_uploader->saveFile();

        $book->save();

        return view('textbook.createProduct')->withBook($book);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
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
        $book = DB::table('books')->where('isbn', $isbn)->first();

        // if the book is in our db, show the book information and let seller edit it
        if ($book)
        {
            return view('textbook.result')->withBook($book);
        }
        // if not, allow the seller fill in book information and create a new book record
        else
        {
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
    public function buy()
    {
        return view('textbook.buy');
    }
}
