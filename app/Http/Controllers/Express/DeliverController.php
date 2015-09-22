<?php

namespace App\Http\Controllers\Express;

use App\Events\BuyerOrderWasDelivered;
use App\Events\BuyerOrderWasShipped;

use App\BuyerOrder;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Auth;
use Illuminate\Http\RedirectResponse;
use Mail;


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
        $buyer_orders = BuyerOrder::all()
            ->filter(function($buyer_order)
            {
                return $buyer_order->isDeliverable();
            });


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

        if ($buyer_order->isDelivered())
        {
            return redirect('express/deliver')->withError('This buyer order has already been delivered.');
        }

        if ($buyer_order->isAssignedToCourier())
        {
            return redirect('express/deliver')->withError('This buyer order has already been taken by another courier.');
        }

        // assign the order to the current courier
        $buyer_order->courier_id = Auth::user()->id;
        $buyer_order->save();

        event(new BuyerOrderWasShipped($buyer_order));

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

        if (!$buyer_order->isAssignedToCourier())
        {
            return redirect('express/deliver')->withError('This buyer order is not assigned to any courier.');
        }

        if ($buyer_order->isDelivered())
        {
            return redirect('express/deliver')->withError('This buyer order has already been delivered.');
        }

        $buyer_order->update([
                                 // add deliver time to the buyer order
                                 'time_delivered'    => date(config('database.datetime_format')),
                             ]);

        event(new BuyerOrderWasDelivered($buyer_order));

        return redirect()->back();
    }
}
