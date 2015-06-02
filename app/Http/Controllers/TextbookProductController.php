<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Auth;
use Input;

use App\Product;
use App\ProductCondition;

class TextbookProductController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($book)
	{
        return view('textbook.createProduct')->withBook($book);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
        $condition = new ProductCondition();
        $condition->highlights = Input::get('highlights');
        $condition->notes = Input::get('notes');
        $condition->num_damaged_pages = Input::get('num_damaged_pages');
        $condition->broken_spine = Input::get('broken_spine');
        $condition->broken_binding = Input::get('broken_binding');
        $condition->water_damage = Input::get('water_damage');
        $condition->stains = Input::get('stains');
        $condition->burns = Input::get('burns');
        $condition->rips = Input::get('rips');
        $condition->save();

        $product = new Product();
        $product->price = Input::get('price');
        $product->book_id = Input::get('book_id');
        $product->seller_id = Auth::user()->id;
        $product->condition_id = $condition->id;
        $product->sold = false;
        $product->save();

        return view('textbook.sell');
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
