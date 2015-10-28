<?php

namespace App\Http\Controllers\Express;

use App\Donation;
use App\Events\BuyerOrderWasDeliverable;
use App\Events\DonationWasAssignedToCourier;
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

        $donations = Donation::unassigned()->notPickedup()->get();

        return view('express.pickup.index')
            ->withSellerOrders($seller_orders)
            ->withDonations($donations);
    }

    /**
     * Display a listing of the seller orders wait to be picked up.
     *
     * @return Response
     */
    public function indexTodo()
    {
        $seller_orders = SellerOrder::where('courier_id', '=', Auth::id())
            ->where('cancelled', '=', false)
            ->whereNotNull('scheduled_pickup_time')
            ->whereNull('pickup_time')
            ->get();

        $donations = Donation::assignedTo(Auth::id())->notPickedup()->get();

        return view('express.pickup.index')
            ->withSellerOrders($seller_orders)
            ->withDonations($donations);
    }

    /**
     * Display a listing of the seller orders that have been picked up.
     *
     * @return Response
     */
    public function indexPickedUp()
    {
        $seller_orders = SellerOrder::where('courier_id', '=', Auth::id())
            ->where('cancelled', '=', false)
            ->whereNotNull('scheduled_pickup_time')
            ->whereNotNull('pickup_time')
            ->get();

        $donations = Donation::assignedTo(Auth::id())->pickedup()->get();

        return view('express.pickup.index')
            ->withSellerOrders($seller_orders)
            ->withDonations($donations);
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

        // if payout method is cash, update the amount of cash paid of the seller order
        if ($seller_order->product->payout_method == 'cash')
        {
            $seller_order->cash_paid = $seller_order->product->price - config('sale.service_fee');
            $seller_order->save();
        }

        // if sell to stuvi, pay the seller
        if ($seller_order->isSoldToStuvi())
        {
            $seller_order->payout();
        }

        // if all seller orders of a buyer order are picked up
        // then the buyer order is deliverable
        if ($seller_order->buyerOrder->hasAllSellerOrdersPickedup())
        {
            event(new BuyerOrderWasDeliverable($seller_order->buyerOrder));
        }

        return redirect()->back();
    }

    /**
     * Display the specified donation.
     *
     * @param  int  $id
     * @return Response
     */
    public function showDonation($id)
    {
        $donation = Donation::find($id);

        return view('express.pickup.showDonation')
            ->withDonation($donation);
    }

    /**
     * Ready to pick up the donation.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function readyToPickUpDonation($id)
    {
        $donation = Donation::find($id);

        if ($donation->courier_id)
        {
            return redirect('express/pickup')->withError('This donation has already been taken by another courier.');
        }

        // assign the order to the current courier
        $donation->courier_id = Auth::user()->id;
        $donation->save();

        event(new DonationWasAssignedToCourier($donation));

        return redirect()->back();
    }

    /**
     * Confirm the seller order has been picked up.
     *
     * @param $id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function confirmPickupDonation($id)
    {
        $donation = Donation::find($id);
        $code = Input::get('pickup_code');

        // validation
        $v = Validator::make(Input::all(), [
            'pickup_code'  => 'required|digits:4'
        ]);

        $v->after(function($v) use ($donation, $code)
        {
            if ($donation->pickup_time)
            {
                return redirect('express/pickup')->withError('This donation has already been picked up.');
            }

            // check if the code is correct
            if ($v->errors()->has('pickup_code') == false && $code != $donation->pickup_code)
            {
                $v->errors()->add('pickup_code', 'Sorry, the code is incorrect. Please try again.');
            }
        });

        if ($v->fails())
        {
            return redirect()->back()
                ->withErrors($v->errors());
        }

        // add pickup time to the seller order
        $donation->pickup_time = date(config('database.datetime_format'));
        $donation->save();

        return redirect()->back();
    }
}
