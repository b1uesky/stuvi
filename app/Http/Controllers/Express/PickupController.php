<?php

namespace App\Http\Controllers\Express;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\SellerOrder;

use Auth;
use Input;
use Validator;

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
            ->whereNull('pickup_time')
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

//        if ($seller_order->pickedUp())
//        {
//            return redirect('express/pickup')->withError('This seller order has already been picked up.');
//        }

        if (!$seller_order->scheduled())
        {
            return redirect('express/pickup')->withError('This seller order has not been scheduled yet.');
        }

        return view('express.pickup.show')->withSellerOrder($seller_order);
    }

    public function confirmPickup($id)
    {
        $code = Input::get('code');
        $seller_order = SellerOrder::find($id);

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


        $seller_order->pickup_time = date('Y/m/d H:i:s');
        $seller_order->save();

        return redirect()->back();
    }
}
