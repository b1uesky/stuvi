<?php

namespace App\Http\Controllers\Admin;

use App\Book;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use Input;
use Validator;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $filters = ['id', 'title', 'isbn10', 'isbn13'];

        $filter   = Input::get('filter');
        $keyword  = trim(strtolower(Input::get('keyword')));

        if (empty($keyword))
        {
            $query = Book::query();
        }
        elseif ($filter == 'id')
        {
            $query = Book::where($filter, intval($keyword));
        }
        elseif ($filter == 'title')
        {
            $query = Book::where('title', 'LIKE', '%' . $keyword . '%');
        }
        elseif ($filter == 'isbn')
        {
            if (strlen($keyword) == 10)
            {
                $query = Book::where('isbn10', 'LIKE', $keyword);
            }
            else
            {
                $query = Book::Where('isbn13', 'LIKE', $keyword);
            }
        }
        else
        {
            $query = Book::query();
        }

        $books = $query->paginate(config('pagination.limit.admin.default'));

        return view('admin.book.index')
            ->with('books', $books)
            ->with('filters', $filters)
            ->with('pagination_params', Input::only(['filter', 'keyword', 'page']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  Book $book
     *
     * @return Response
     */
    public function show($book)
    {
        return view('admin.book.show')
            ->with('book', $book)
            ->with('products', $book->products);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Book $book
     *
     * @return Response
     */
    public function edit($book)
    {
        return view('admin.book.edit')
            ->with('book', $book);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Book $book
     *
     * @return Response
     */
    public function update($book)
    {
        $v = Validator::make(Input::all(), Book::updateRules());

        if ($v->fails())
        {
            return redirect()->back()->with('errors', $v->errors());
        }

        $book->update(Input::all());

        return redirect('admin/book')->with('success', 'Updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Book $book
     *
     * @return Response
     */
    public function destroy($book)
    {
        $title = $book->title;
        $book->delete();

        return redirect('admin/book')
            ->with('success', 'You have successfully deleted book: '.$title);
    }
}
