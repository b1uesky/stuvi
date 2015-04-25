<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\User;
use App\Book;

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

    public function buy()
    {
        return view('textbook.buy');
    }

    public function sell()
    {
        return view('textbook.sell');
    }

    public function search(Request $request)
    {
        $isbn = $request->input('isbn');
        $books = Book::where('isbn', '=', $isbn);

        if ($books->count() > 0)
        {
            $data = array(
                'books' => $books
            );

            return view('textbook.result', $data);
        }
        else
        {
            return redirect('textbook/sell/create')->with(
                'message',
                'Looks like your textbook is currently not in our database, please fill in the textbook information below.');
        }
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
		$isbn = $request->input('isbn');
        $title = $request->input('title');
        $author = $request->input('author');
        $edition = $request->input('edition');
        $publisher = $request->input('publisher');
        $publication_date = $request->input('publication_date');
        $manufacturer = $request->input('manufacturer');
        $num_pages = $request->input('num_pages');
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

}
