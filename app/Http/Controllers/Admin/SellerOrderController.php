<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\SellerOrder;

use Config;

class SellerOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $seller_orders = SellerOrder::paginate(Config::get('pagination.limit.admin.seller_order'));

        return view('admin.sellerOrder.index')->withSellerOrders($seller_orders);
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
