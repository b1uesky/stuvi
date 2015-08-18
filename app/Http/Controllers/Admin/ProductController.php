<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Product;
use Config;
use Input;

class ProductController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $filter   = Input::get('filter');
        $keyword  = strtolower(Input::get('keyword'));
        $order_by = Input::get('order_by', 'id');
        $order    = Input::get('order', 'DESC');

        // filter
        if (empty($keyword))
        {
            $query = Product::query();
        }
        elseif ($filter == 'id')
        {
            $query = Product::where($filter, intval($keyword));
        }
        elseif ($filter == 'title')
        {
            $query = Product::buildQueryWithBookTitle($keyword);
        }
        elseif ($filter == 'seller')
        {
            $query = Product::buildQueryWithSellerName($keyword);
        }
        else
        {
            $query = Product::query();
        }

        // order
        if ($order_by == 'title')
        {
            $query = $query->join('books', 'products.book_id', '=', 'books.id')
                            ->select('products.*', 'books.title');
        }
        elseif ($order_by == 'first_name' || $order_by == 'last_name')
        {
            $query = $query->join('users', 'products.seller_id', '=', 'users.id')
                            ->select('products.*', 'users.'.$order_by);
        }

        $products = $query->orderBy($order_by, $order)->paginate(Config::get('pagination.limit.admin.product'));

        return view('admin.product.index')
            ->with('products', $products)
            ->with('pagination_params', Input::only([
                                                        'filter',
                                                        'keyword',
                                                        'order_by',
                                                        'order',
                                                        'page',
                                                    ]));
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
     * @param  Product $product
     *
     * @return Response
     */
    public function show($product)
    {
        return view('admin.product.show')
            ->with('product', $product)
            ->with('conditions', Config::get('product.conditions'))
            ->with('seller_orders', $product->sellerOrders);
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
