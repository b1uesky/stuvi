<?php namespace App\Http\Controllers\Textbook;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;
use App\Address;
use App\Product;
use App\BuyerOrder;
use App\SellerOrder;
use App\BuyerPayment;

use Auth, Input, Cart, Session, DB, Config, \DateTime;

class SellerOrderController extends Controller
{

    /**
     * Display a listing of seller orders for an user.
     *
     * @return Response
     */
    public function sellerOrderIndex()
    {
        return view('order.sellerOrderIndex')
            ->with('orders', User::find(Auth::id())->sellerOrders);
    }

    public function bookshelf()
    {
        return view('order.sellerBookshelfIndex');
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
        $scheduled_pickup_time = DateTime::createFromFormat("d/m/Y G:i", Input::get('scheduled_pickup_time'))->format('Y-m-d G:i:s');
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

            $seller_order->scheduled_pickup_time    = $scheduled_pickup_time;
            $seller_order->save();
            return redirect('order/seller/'.$id);
        }

        return redirect('order/seller')
            ->with('message', 'Order not found');
    }
}
