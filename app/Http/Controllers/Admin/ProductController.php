<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Product;
use Config;

class ProductController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $products = Product::paginate(Config::get('pagination.limit.admin.product'));

        return view('admin.product.index')
            ->with('products', $products);
    }

    /**
     * Display unverified products.
     *
     * @return mixed
     */
    public function showUnverified()
    {
        $unverified = Product::where('verified', '=', false)
                             ->get();

        return view('admin.product.index')->withProducts($unverified);
    }

    /**
     * Display verified products.
     *
     * @return mixed
     */
    public function showVerified()
    {
        $verified = Product::where('verified', '=', true)
                           ->get();

        return view('admin.product.index')->withProducts($verified);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        return view('admin.product.show')
            ->withProduct($id)
            ->withConditions(Config::get('product.conditions'));
    }

    /**
     * Approve a product ($product->verified = true)
     *
     * @param $id
     *
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

    /**
     * Disapprove a product ($product->verified = false)
     *
     * @param $id
     *
     * @return mixed
     */
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
