<?php

namespace App\Http\Controllers\Express;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\BuyerOrder;

use Auth;
use Illuminate\Http\RedirectResponse;
use Mail;
use Config;


class DeliverController extends Controller
{
    /**
     * Display a listing of the buyer orders that are not assigned to
     * couriers, not cancelled and not delivered.
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
     * Display a listing of the buyer orders waited to be delivered by
     * this courier. They must not be cancelled or delivered.
     *
     * @return Response
     */
    public function indexTodo()
    {
        $buyer_orders = BuyerOrder::where('courier_id', '=', Auth::user()->id)
            ->where('cancelled', '=', false)
            ->whereNull('time_delivered')
            ->get();

        return view('express.deliver.index')->withBuyerOrders($buyer_orders);
    }

    /**
     * Display a listing of the buyer orders delivered by this courier.
     *
     * @return Response
     */
    public function indexDelivered()
    {
        $buyer_orders = BuyerOrder::where('courier_id', '=', Auth::user()->id)
            ->where('cancelled', '=', false)
            ->whereNotNull('time_delivered')
            ->get();

        return view('express.deliver.index')->withBuyerOrders($buyer_orders);
    }

    /**
     * Display the specified buyer order.
     * Only show an order that is not cancelled and not delivered yet.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $buyer_order = BuyerOrder::find($id);

        if ($buyer_order->cancelled)
        {
            return redirect('express/deliver')->withError('This buyer order has been cancelled.');
        }

        return view('express.deliver.show')->withBuyerOrder($buyer_order);
    }

    /**
     * Assign an order to the current courier and notify the buyer by email.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function readyToShip($id)
    {
        $buyer_order = BuyerOrder::find($id);

        if ($buyer_order->cancelled)
        {
            return redirect('express/deliver')->withError('This buyer order has been cancelled.');
        }

        if ($buyer_order->delivered())
        {
            return redirect('express/deliver')->withError('This buyer order has already been delivered.');
        }

        if ($buyer_order->assignedToCourier())
        {
            return redirect('express/deliver')->withError('This buyer order has already been taken by another courier.');
        }

        // assign the order to the current courier
        $buyer_order->courier_id = Auth::user()->id;
        $buyer_order->save();

        // convert the buyer order and corresponding objects to an array
        $buyer_order_arr                        = $buyer_order->toArray();
        $buyer_order_arr['buyer']               = $buyer_order->buyer->toArray();
        $buyer_order_arr['shipping_address']    = $buyer_order->shipping_address->toArray();
        $buyer_order_arr['buyer_payment']       = $buyer_order->buyer_payment->toArray();
        foreach ($buyer_order->products() as $product)
        {
            $temp           = $product->toArray();
            $temp['book']   = $product->book->toArray();
            $temp['book']['authors']        = $product->book->authors->toArray();
            $temp['book']['image_set']      = $product->book->imageSet->toArray();
            $buyer_order_arr['products'][]   = $temp;
        }

        // send an email notification to the buyer
        Mail::queue('emails.buyerOrder.ready', [
            'buyer_order' => $buyer_order_arr
        ], function($message) use ($buyer_order)
        {
            $message->to($buyer_order->buyer->email)->subject('Your order #'.$buyer_order->id.' is on the way!');
        });

        return redirect()->back();
    }

    /**
     * Confirm the textbook has been delivered.
     *
     * @param $id
     * @return RedirectResponse
     */
    public function confirmDelivery($id)
    {
        $buyer_order = BuyerOrder::find($id);

        if ($buyer_order->cancelled)
        {
            return redirect('express/deliver')->withError('This buyer order has been cancelled.');
        }

        if (!$buyer_order->assignedToCourier())
        {
            return redirect('express/deliver')->withError('This buyer order is not assigned to any courier.');
        }

        if ($buyer_order->delivered())
        {
            return redirect('express/deliver')->withError('This buyer order has already been delivered.');
        }

        // add deliver time to the seller order
        $buyer_order->time_delivered = date(Config::get('app.datetime_format'));
        $buyer_order->save();

        // assign the order to the current courier
        $buyer_order->courier_id = Auth::user()->id;
        $buyer_order->save();

        // convert the buyer order and corresponding objects to an array
        $buyer_order_arr                        = $buyer_order->toArray();
        $buyer_order_arr['buyer']               = $buyer_order->buyer->toArray();
        $buyer_order_arr['shipping_address']    = $buyer_order->shipping_address->toArray();
        $buyer_order_arr['buyer_payment']       = $buyer_order->buyer_payment->toArray();
        foreach ($buyer_order->products() as $product)
        {
            $temp           = $product->toArray();
            $temp['book']   = $product->book->toArray();
            $temp['book']['authors']        = $product->book->authors->toArray();
            $temp['book']['image_set']      = $product->book->imageSet->toArray();
            $buyer_order_arr['products'][]   = $temp;
        }


        // send an email notification to the buyer
        Mail::queue('emails.buyerOrder.confirmDelivery', [
            'buyer_order'   => $buyer_order_arr
        ], function($message) use ($buyer_order)
        {
            $message->to($buyer_order->buyer->email)->subject('Your order #'.$buyer_order->id.' has been delivered!');
        });

        return redirect()->back();
    }
}
