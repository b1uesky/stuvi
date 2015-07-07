<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Product;
use Config;

class ProductController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$products = Product::all();

        return view('admin.product.index')->withProducts($products);
	}

    public function showUnverified()
    {
        $unverified = Product::where('verified', '=', false)->get();

        return view('admin.product.index')->withProducts($unverified);
    }

    public function showVerified()
    {
        $verified = Product::where('verified', '=', true)->get();

        return view('admin.product.index')->withProducts($verified);
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
	 * @return Responser
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        return view('admin.product.show')
            ->withProduct($id)
            ->withConditions(Config::get('product.conditions'));
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

    /**
     * Approve a product ($product->verified = true)
     *
     * @param $id
     * @return mixed
     */
	public function approve($id)
	{
		$product = Product::find($id);

		if ($product->verified == false)
		{
			$product->verified = true;
			$product->save();

            return redirect()
                ->back()
                ->withSuccess('Product ' . $product->id . ' has been approved.');
		}

		return redirect()
            ->back()
            ->withError('Product ' . $product->id . ' has already been approved.');
	}

	public function disapprove($id)
	{
		$product = Product::find($id);

		if ($product->verified == true)
		{
			$product->verified = false;
			$product->save();

            return redirect()
                ->back()
                ->withSuccess('Product ' . $product->id . ' has been disapproved.');
		}

		return redirect()
            ->back()
            ->withError('Product ' . $product->id . ' has already been disapproved');
	}
}