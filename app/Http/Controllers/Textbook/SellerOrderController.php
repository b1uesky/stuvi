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
        $order = Input::get('ord');
        // check column existence
        $order = $this->hasColumn('seller_orders', $order) ? $order : 'id';

        return view('order.seller.index')
            ->with('seller_orders', Auth::user()->sellerOrders()
                ->orderBy($order, 'DESC')->get());
    }

    /**
     * Display a specific seller order.
     *
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function show($id)
    {
        $seller_order = SellerOrder::find($id);

        // check if this order belongs to the current user.
        if (!is_null($seller_order) && $seller_order->isBelongTo(Auth::id()))
        {
            return view('order.seller.show')
                ->with('seller_order', $seller_order);
        }

        return redirect('order/seller')
            ->with('error', 'Order not found');
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
     * Schedule pickup page.
     *
     * @param $seller_order_id
     * @return mixed
     */
    public function schedulePickup($seller_order_id)
    {
        $seller_order = SellerOrder::find($seller_order_id);

        if ($seller_order->isPickupConfirmable())
        {
            return view('order.seller.schedulePickup')
                ->withSellerOrder($seller_order);
        }

        return redirect('order/seller')
            ->with('error', 'You cannot update the pickup details because the order has been assigned to a courier or cancelled.');
    }

    /**
     * The pickup has been confirmed and send an email to the seller about the pickup details.
     *
     * @param $id
     *
     * @return mixed
     */
    public function confirmPickup($id)
    {
        $seller_order = SellerOrder::find($id);

        $v = Validator::make(Input::all(), SellerOrder::confirmPickupRules());

        if ($v->fails())
        {
            return redirect()->back()->withErrors($v->errors());
        }

        $seller_order->update([
            'address_id'            => Input::get('address_id'),
            'scheduled_pickup_time' => DateTime::saveDatetime(Input::get('scheduled_pickup_time'))
        ]);

        // send an email with a pickup verification code to the seller
        $seller_order->generatePickupCode();

        event(new SellerOrderPickupWasScheduled($seller_order));

        return redirect()->back()
            ->withSuccess("You have successfully updated the pickup and we'll email you the details shortly.");
    }

    public function payout()
    {
        $seller_order_id = Input::get('seller_order_id');
        $seller_order = SellerOrder::find($seller_order_id);

        // check if this seller order belongs to the current user, or null.
        if (empty($seller_order) || !$seller_order->isBelongTo(Auth::id()))
        {
            return redirect('/order/seller')
                ->with('error', 'Order not found.');
        }

        // check if this seller order is transferred.
        if ($seller_order->isTransferred())
        {
            return redirect('/order/seller/' . $seller_order_id)
                ->with('error', 'You have already transferred the balance of this order to your Paypal account.');
        }

        // check if this seller order is delivered
        if (!$seller_order->isDelivered())
        {
            return redirect('/order/seller/' . $seller_order_id)
                ->with('error', 'This order is not delivered yet. You can get your money back once the buyer get the book.');
        }

        if ($seller_order->cancelled)
        {
            return redirect('/order/seller/' . $seller_order_id)
                ->with('error', 'This order has been cancelled.');
        }

        $payout_item = $seller_order->payout();
        if (!$payout_item)
        {
            redirect('/order/seller/'.$seller_order_id)
                ->with('error', 'Sorry, we cannot transfer the balance to your Paypal account. Please contact Stuvi.');
        }

        return redirect('/order/seller/'.$seller_order_id)
            ->with('success', 'The balance has been transferred to your paypal account '.$seller_order->seller()->profile->paypal);
    }


}
