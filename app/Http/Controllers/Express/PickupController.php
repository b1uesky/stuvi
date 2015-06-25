<?php

namespace App\Http\Controllers\Express;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\SellerOrder;

use Auth;

class PickupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $seller_orders = SellerOrder::where('courier_id', '=', Auth::user()->id)
            ->whereNotNull('scheduled_pickup_time')
            ->get();

        return view('express.pickup.index')
            ->withSellerOrders($seller_orders);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $seller_order = SellerOrder::find($id);

        if ($seller_order->scheduled())
        {
            return view('express.pickup.show')->withSellerOrder($seller_order);
        }
        else
        {
            return redirect('express/pickup')->withError('This seller order has not been scheduled yet.');
        }
    }
}
