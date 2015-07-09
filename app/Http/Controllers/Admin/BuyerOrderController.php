<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\BuyerOrder;

class BuyerOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $buyer_orders = BuyerOrder::all();

        return view('admin.buyerOrder.index')->withBuyerOrders($buyer_orders);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        return view('admin.buyerOrder.show')
            ->with('buyer_order', BuyerOrder::find($id));
    }
}
