<?php

namespace App\Http\Controllers\Express;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\SellerOrder;

use Auth;
use Input;
use Config;
use Validator;

class PickupController extends Controller
{
    /**
     * Display a listing of the seller orders.
     *
     * Only show orders with assigned courier, scheduled pickup time
     * and not picked up.
     *
     * @return Response
     */
    public function index()
    {
        $seller_orders = SellerOrder::where('courier_id', '=', Auth::user()->id)
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

        if (!$seller_order->scheduled())
        {
            return redirect('express/pickup')->withError('This seller order has not been scheduled yet.');
        }

        return view('express.pickup.show')->withSellerOrder($seller_order);
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

            if (!$seller_order->scheduled())
            {
                return redirect('express/pickup')->withError('This seller order has not been scheduled yet.');
            }

            // validate the code
            if ($code != $seller_order->pickup_code)
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
        $seller_order->pickup_time = date(Config::get('app.datetime_format'));
        $seller_order->save();

        return redirect()->back();
    }
}
