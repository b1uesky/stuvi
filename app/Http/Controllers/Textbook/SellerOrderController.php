<?php namespace App\Http\Controllers\Textbook;

use Aloha\Twilio\Twilio;
use App\Address;
use App\Events\SellerOrderPickupWasScheduled;
use App\Events\SellerOrderWasCancelled;
use App\Helpers\DateTime;
use App\Http\Controllers\Controller;
use App\Listeners\EmailSellerOrderPickupConfirmation;
use App\SellerOrder;
use Auth;
use Carbon\Carbon;
use Cart;
use DB;
use Input;
use Log;
use Mail;
use Request;
use Response;
use Session;
use Validator;

class SellerOrderController extends Controller
{

    /**
     * Display a listing of seller orders for an user.
     *
     * @return Response
     */
    public function index()
    {
        $seller_orders = Auth::user()->sellerOrders()
            ->orderBy('cancelled')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('order.seller.index')
            ->with('seller_orders', $seller_orders);
    }

    /**
     * Display a specific seller order.
     *
     * @param SellerOrder $seller_order
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function show($seller_order)
    {
        // check if this order belongs to the current user.
        if (!is_null($seller_order) && $seller_order->isBelongTo(Auth::id()))
        {
            return view('order.seller.show')
                ->with('seller_order', $seller_order);
        }

        return redirect('order/seller')
            ->with('error', 'Order not found.');
    }

    /**
     * Cancel a specific seller order.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function cancel()
    {
        $v = Validator::make(Input::all(), [
            'seller_order_id'   => 'required|integer|exists:seller_orders,id',
            'cancel_reason'     => 'required|string'
        ]);

        if ($v->fails())
        {
            return redirect()->back()->withErrors($v->errors());
        }

        $seller_order_id = Input::get('seller_order_id');
        $seller_order = SellerOrder::find($seller_order_id);
        $cancel_reason = Input::get('cancel_reason');

        // check if this order belongs to the current user.
        if ($seller_order->isBelongTo(Auth::id()))
        {
            if ($seller_order->isCancellable())
            {
                $seller_order->cancel(Auth::id(), $cancel_reason);

                event(new SellerOrderWasCancelled($seller_order));

                return redirect()->back()
                    ->with('success', 'Your order has been cancelled.');
            }
        }

        return redirect()->back()
            ->with('error', 'Sorry, this order cannot be cancelled.');
    }

    /**
     * Cancel a book trade-in offer.
     *
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function cancelTradeIn()
    {
        $v = Validator::make(Input::all(), [
            'seller_order_id'   => 'required|integer|exists:seller_orders,id'
        ]);

        if ($v->fails())
        {
            return redirect()->back()->withErrors($v->errors());
        }

        $seller_order_id = Input::get('seller_order_id');
        $seller_order = SellerOrder::find($seller_order_id);

        // check if this order belongs to the current user.
        if ($seller_order->isBelongTo(Auth::id()))
        {
            if ($seller_order->isCancellable())
            {
                $seller_order->update([
                    'cancelled'         => true,
                    'cancelled_time'    => Carbon::now(),
                    'cancelled_by'      => Auth::id(),
                    'cancel_reason'     => 'User was not interested in this trade-in offer.'
                ]);

                return redirect()->back()
                    ->with('success', 'You have successfully removed this trade-in offer.');
            }
        }

        return redirect()->back()
            ->with('error', 'Sorry, you cannot remove this trade-in offer.');
    }

    /**
     * Schedule pickup page.
     *
     * @param SellerOrder $seller_order
     * @return mixed
     */
    public function schedulePickup($seller_order)
    {
        if ($seller_order->isBelongTo(Auth::id()) && $seller_order->isPickupSchedulable())
        {
            return view('order.seller.schedulePickup')
                ->withSellerOrder($seller_order);
        }

        return redirect('order/seller')
            ->with('error', 'You cannot update the pickup details for this order.');
    }

    /**
     * The pickup has been confirmed and send an email to the seller about the pickup details.
     *
     * @param SellerOrder $seller_order
     *
     * @return mixed
     */
    public function confirmPickup($seller_order)
    {
        if (!$seller_order->isBelongTo(Auth::id()) || !$seller_order->isPickupSchedulable())
        {
            return redirect('order/seller')
                ->with('error', 'You cannot update the pickup details for this order.');
        }

        $v = Validator::make(Input::all(), SellerOrder::confirmPickupRules());

        if ($v->fails())
        {
            return redirect()->back()->withErrors($v->errors());
        }

        $seller_order->update([
            'address_id'            => Input::get('address_id'),
            'scheduled_pickup_time' => DateTime::saveDatetime(Input::get('scheduled_pickup_time')),
            'pickup_code'           => \App\Helpers\generateRandomNumber(4)
        ]);

        // if this order is sold to stuvi, mark the product as sold
        if ($seller_order->isSoldToStuvi())
        {
            $seller_order->product->update([
                'sold'  => true
            ]);
        }

        event(new SellerOrderPickupWasScheduled($seller_order));

        return redirect('order/seller')
            ->withSuccess("You have successfully updated the pickup and we'll email you the details shortly.");
    }

    /**
     * Pay the seller.
     *
     * @param $seller_order
     * @return \Illuminate\Http\RedirectResponse
     */
    public function payout($seller_order)
    {
        // check if this seller order belongs to the current user, or null.
        if (empty($seller_order) || !$seller_order->isBelongTo(Auth::id()))
        {
            return redirect('/order/seller')
                ->with('error', 'Order not found.');
        }

        // check if this seller order is transferred.
        if ($seller_order->isTransferred())
        {
            return redirect('/order/seller/' . $seller_order->id)
                ->with('error', 'You have already transferred the balance of this order to your Paypal account.');
        }

        // check if this seller order is delivered
        if (!$seller_order->isDelivered())
        {
            return redirect('/order/seller/' . $seller_order->id)
                ->with('error', 'This order is not delivered yet. You can get your money back once the buyer get the book.');
        }

        if ($seller_order->cancelled)
        {
            return redirect('/order/seller/' . $seller_order->id)
                ->with('error', 'This order has been cancelled.');
        }

        $payout_item = $seller_order->payout();

        if (!$payout_item)
        {
            redirect('/order/seller/'.$seller_order->id)
                ->with('error', 'Sorry, we cannot transfer the balance to your Paypal account. Please contact Stuvi.');
        }

        return redirect('/order/seller/'.$seller_order->id)
            ->with('success', 'The balance has been transferred to your paypal account '.$seller_order->seller()->profile->paypal);
    }


}
