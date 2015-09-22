<?php

namespace App\Http\Controllers\Express;

use App\Events\SellerOrderWasAssignedToCourier;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\SellerOrder;

use Auth;
use Input;
use Validator;

class PickupController extends Controller
{
    /**
     * Display a listing of the seller orders.
     *
     * Only show orders with unassigned courier, not cancelled,
     * scheduled pickup time and not picked up.
     *
     * @return Response
     */
    public function index()
    {
        $seller_orders = SellerOrder::whereNull('courier_id')
            ->where('cancelled', '=', false)
            ->whereNotNull('scheduled_pickup_time')
            ->whereNull('pickup_time')
            ->get();

        return view('express.pickup.index')
            ->withSellerOrders($seller_orders);
    }

    /**
     * Display a listing of the seller orders wait to be picked up.
     *
     * @return Response
     */
    public function indexTodo()
    {
        $seller_orders = SellerOrder::where('courier_id', '=', Auth::user()->id)
            ->where('cancelled', '=', false)
            ->whereNotNull('scheduled_pickup_time')
            ->whereNull('pickup_time')
            ->get();

        return view('express.pickup.index')
            ->withSellerOrders($seller_orders);
    }

    /**
     * Display a listing of the seller orders that have been picked up.
     *
     * @return Response
     */
    public function indexPickedUp()
    {
        $seller_orders = SellerOrder::where('courier_id', '=', Auth::user()->id)
            ->where('cancelled', '=', false)
            ->whereNotNull('scheduled_pickup_time')
            ->whereNotNull('pickup_time')
            ->get();

        return view('express.pickup.index')
            ->withSellerOrders($seller_orders);
    }

    /**
     * Display the specified seller order.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $seller_order = SellerOrder::find($id);

        if ($seller_order->cancelled)
        {
            return redirect('express/pickup')->withError('This seller order has been cancelled.');
        }

        if (!$seller_order->isScheduled())
        {
            return redirect('express/pickup')->withError('This seller order has not been scheduled yet.');
        }

        return view('express.pickup.show')->withSellerOrder($seller_order);
    }

    /**
     *
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function readyToPickUp($id)
    {
        $seller_order = SellerOrder::find($id);

        if ($seller_order->cancelled)
        {
            return redirect('express/pickup')->withError('This seller order has been cancelled.');
        }

        if (!$seller_order->isScheduled())
        {
            return redirect('express/pickup')->withError('This seller order has not been scheduled yet.');
        }

        if ($seller_order->isAssignedToCourier())
        {
            return redirect('express/pickup')->withError('This seller order has already been taken by another courier.');
        }

        // assign the order to the current courier
        $seller_order->courier_id = Auth::user()->id;
        $seller_order->save();

        event(new SellerOrderWasAssignedToCourier($seller_order));

        return redirect()->back();
    }

    /**
     * Confirm the seller order has been picked up.
     *
     * @param $id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function confirmPickup($id)
    {
        $code = Input::get('code');
        $seller_order = SellerOrder::find($id);

        // validation
        $v = Validator::make(Input::all(), [
            'code'  => 'required|digits:4'
        ]);

        $v->after(function($v) use ($seller_order, $code)
        {
            if ($seller_order->pickedUp())
            {
                return redirect('express/pickup')->withError('This seller order has already been picked up.');
            }

            if (!$seller_order->isScheduled())
            {
                return redirect('express/pickup')->withError('This seller order has not been scheduled yet.');
            }

            // check if the code is correct
            if ($v->errors()->has('code') == false && $code != $seller_order->pickup_code)
            {
                $v->errors()->add('code', 'Sorry, the code is incorrect. Please try again.');
            }
        });

        if ($v->fails())
        {
            return redirect()->back()
                ->withErrors($v->errors());
        }

        // add pickup time to the seller order
        $seller_order->pickup_time = date(config('database.datetime_format'));
        $seller_order->save();

        return redirect()->back();
    }
}
