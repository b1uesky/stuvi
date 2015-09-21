<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\SellerOrder;
use Input;

class SellerOrderController extends Controller
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
            $query = SellerOrder::query();
        }
        elseif ($filter == 'id')
        {
            $query = SellerOrder::where($filter, intval($keyword));
        }
        elseif ($filter == 'title')
        {
            $query = SellerOrder::buildQueryWithBookTitle($keyword);
        }
        elseif ($filter == 'seller')
        {
            $query = SellerOrder::buildQueryWithSellerName($keyword);
        }
        else
        {
            $query = SellerOrder::query();
        }

        // order
        if ($order_by == 'title')
        {
            $query = $query->join('products', 'seller_orders.product_id', '=', 'products.id')
                           ->join('books', 'products.book_id', '=', 'books.id')
                           ->select('seller_orders.*', 'books.title');
        }
        elseif ($order_by == 'first_name' || $order_by == 'last_name')
        {
            $query = $query->join('products', 'seller_orders.product_id', '=', 'products.id')
                           ->join('users', 'products.seller_id', '=', 'users.id')
                           ->select('seller_orders.*', 'users.'.$order_by);
        }

        $seller_orders = $query->orderBy($order_by, $order)->paginate(config('pagination.limit.admin.seller_order'));

        return view('admin.sellerOrder.index')->withSellerOrders($seller_orders)
            ->with('pagination_params', Input::only([
                                                        'filter',
                                                        'keyword',
                                                        'order_by',
                                                        'order',
                                                        'page',
                                                    ]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        return view('admin.sellerOrder.show')
            ->with('seller_order', SellerOrder::find($id));
    }
}
