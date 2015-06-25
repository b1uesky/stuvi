<?php

namespace App\Http\Controllers\Express;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\BuyerOrder;


class DeliverController extends Controller
{
    /**
     * Display a listing of the buyer orders.
     *
     * Only show orders that are not assigned to a specific courier,
     * not cancelled and not delivered.
     *
     * @return Response
     */
    public function index()
    {
        $buyer_orders = BuyerOrder::whereNull('courier_id')
            ->where('cancelled', '=', false)
            ->whereNull('time_delivered')
            ->get();

        return view('express.deliver.index')->withBuyerOrders($buyer_orders);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $buyer_order = BuyerOrder::find($id);
        return view('express.deliver.show')->withBuyerOrder($buyer_order);
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
