<?php namespace App\Http\Controllers\Textbook;

use App\Http\Controllers\Controller;
use App\SellerOrder;
use App\User;
use Auth;
use Cart;
use Config;
use DateTime;
use DB;
use Input;
use Session;
use Mail;

class SellerOrderController extends Controller
{

    /**
     * Display a listing of seller orders for an user.
     *
     * @return Response
     */
    public function sellerOrderIndex()
    {
        $order = Input::get('ord');
        // check column existence
        $order = $this->hasColumn('seller_orders', $order) ? $order : 'id';

        return view('order.sellerOrderIndex')
            ->with('orders', Auth::user()->sellerOrders()->orderBy($order, 'DESC')->get());
    }


    /**
     * Display a specific seller order.
     *
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function showSellerOrder($id)
    {
        $seller_order = SellerOrder::find($id);

        // check if this order belongs to the current user.
        if (!is_null($seller_order) && $seller_order->isBelongTo(Auth::id()))
        {
            return view('order.showSellerOrder')
                ->withSellerOrder($seller_order)
                ->with('datetime_format', Config::get('app.datetime_format'));
        }

        return redirect('order/seller')
            ->with('message', 'Order not found');
    }

    /**
     * Cancel a specific seller order.
     *
     * @param $id  The buyer order id.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function cancelSellerOrder($id)
    {
        $seller_order = SellerOrder::find($id);

        // check if this order belongs to the current user.
        if (!is_null($seller_order) && $seller_order->isBelongTo(Auth::id()))
        {
            $seller_order->cancel();
            return redirect('order/seller/'.$id);
        }

        return redirect('order/seller')
            ->with('message', 'Order not found.');
    }

    /**
     * Set the schedule pickup time for a seller order.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function setScheduledPickupTime()
    {
        // TODO: validation
        $scheduled_pickup_time  = Input::get('scheduled_pickup_time');
        $id                     = (int)Input::get('id');
        $seller_order           = SellerOrder::find($id);

        // check if this seller order belongs to the current user.
        if (!is_null($seller_order) && $seller_order->isBelongTo(Auth::id()))
        {
            // if this seller order is cancelled, user cannot set up pickup time
            if ($seller_order->cancelled)
            {
                return redirect('order/seller/'.$id)
                    ->with('message', 'Fail to set pickup time because this order has been cancelled.');
            }

            $scheduled_pickup_time = DateTime::createFromFormat("m/d/Y H:i", $scheduled_pickup_time)->format('Y-m-d G:i:s');

            $seller_order->scheduled_pickup_time    = $scheduled_pickup_time;
            $seller_order->save();

            // send an email with a verification code to the seller to verify
            // that the courier has picked up the book
            $seller = $seller_order->seller();
            $seller_order->generatePickupCode();

            Mail::queue('emails.sellerOrderScheduledPickupTime', [
                'first_name'            => $seller->first_name,
                'scheduled_pickup_time' => $scheduled_pickup_time,
                'pickup_code'             => $seller_order->pickup_code
            ], function($message) use ($seller)
            {
                $message->to('kingdido999@gmail.com')->subject('Your textbook pickup time has been scheduled.');
            });


            return redirect('order/seller/'.$id);
        }

        return redirect('order/seller')
            ->with('message', 'Order not found');
    }
}
