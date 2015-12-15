<?php namespace App\Http\Controllers\Textbook;

use Aloha\Twilio\Twilio;
use App\Address;
use App\Events\SellerOrderPickupWasScheduled;
use App\Events\SellerOrderWasCancelled;
use App\Helpers\DateTime;
use App\Http\Controllers\Controller;
use App\Http\Requests\CancelSellerOrderRequest;
use App\Http\Requests\CancelTradeInRequest;
use App\Http\Requests\ConfirmPickupRequest;
use App\Http\Requests\SchedulePickupRequest;
use App\Http\Requests\ShowSellerOrderRequest;
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
     * @param $request
     * @param SellerOrder $seller_order
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function show(ShowSellerOrderRequest $request, $seller_order)
    {
        return view('order.seller.show')
            ->with('seller_order', $seller_order);
    }

    /**
     * Cancel a specific seller order.
     *
     * @param $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function cancel(CancelSellerOrderRequest $request)
    {
        $seller_order = SellerOrder::find($request->get('seller_order_id'));
        $cancel_reason = $request->get('cancel_reason');

        if ($seller_order->isCancellable())
        {
            $seller_order->cancel(Auth::id(), $cancel_reason);

            event(new SellerOrderWasCancelled($seller_order));

            return redirect()->back()
                ->with('success', 'Your order has been cancelled.');
        }
        else
        {
            return redirect()->back()
                ->with('error', 'Sorry, this order cannot be cancelled.');
        }
    }

    /**
     * Cancel a book trade-in offer.
     *
     * @param $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function cancelTradeIn(CancelTradeInRequest $request)
    {
        $seller_order = SellerOrder::find($request->get('seller_order_id'));

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
        else
        {
            return redirect()->back()
                ->with('error', 'Sorry, you cannot remove this trade-in offer.');
        }
    }

    /**
     * Schedule pickup page.
     *
     * @param $request
     * @param SellerOrder $seller_order
     * @return mixed
     */
    public function schedulePickup(SchedulePickupRequest $request, $seller_order)
    {
        if ($seller_order->isPickupSchedulable())
        {
            return view('order.seller.schedulePickup')
                ->withSellerOrder($seller_order);
        }
        else
        {
            return redirect('order/seller')
                ->with('error', 'You cannot update the pickup details for this order.');
        }
    }

    /**
     * The pickup has been confirmed and send an email to the seller about the pickup details.
     *
     * @param $request
     * @param SellerOrder $seller_order
     *
     * @return mixed
     */
    public function confirmPickup(ConfirmPickupRequest $request, $seller_order)
    {
        if ($seller_order->isPickupSchedulable())
        {
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
                ->withSuccess("You have successfully scheduled a pickup and we'll notify you once our courier is ready to pick up your book.");
        }
        else
        {
            return redirect('order/seller')
                ->with('error', 'You cannot update the pickup details for this order.');
        }
    }

    /**
     * Pay the seller.
     *
     * @param $seller_order
     * @return \Illuminate\Http\RedirectResponse
     */
    public function payout($seller_order)
    {
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
