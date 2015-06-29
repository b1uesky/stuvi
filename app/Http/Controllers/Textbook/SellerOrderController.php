<?php namespace App\Http\Controllers\Textbook;

use App\Helpers\StripeKey;
use App\Http\Controllers\Controller;
use App\SellerOrder;
use Auth;
use Cart;
use Config;
use DB;
use Input;
use Mail;
use Session;
use Validator;

use Carbon\Carbon;

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
            ->with('orders',    Auth::user()->sellerOrders()->orderBy($order, 'DESC')->get());
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
                ->with('seller_order',      $seller_order)
                ->with('datetime_format',   Config::get('app.datetime_format'))
                ->with('stripe_authorize_url',  $this->buildStripeAuthRequestUrl());
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

            return redirect('order/seller/' . $id);
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
        // validation
        $v = Validator::make(Input::all(), [
            'scheduled_pickup_time' => 'required|date'
        ]);

        if ($v->fails())
        {
            return redirect()->back()
                ->withErrors($v->errors())
                ->withInput(Input::all());
        }

        $scheduled_pickup_time = Input::get('scheduled_pickup_time');
        $id = (int)Input::get('id');
        $seller_order = SellerOrder::find($id);

        // check if this seller order belongs to the current user.
        if (!is_null($seller_order) && $seller_order->isBelongTo(Auth::id()))
        {
            // if this seller order is cancelled, user cannot set up pickup time
            if ($seller_order->cancelled)
            {
                return redirect('order/seller/' . $id)
                    ->with('message', 'Fail to set pickup time because this order has been cancelled.');
            }

            $seller_order->scheduled_pickup_time    = Carbon::now();
            $seller_order->save();

            // send an email with a verification code to the seller to verify
            // that the courier has picked up the book
            $seller = $seller_order->seller();
            $seller_order->generatePickupCode();

            Mail::queue('emails.sellerOrderScheduledPickupTime', [
                'first_name'            => $seller->first_name,
                'scheduled_pickup_time' => $scheduled_pickup_time,
                'pickup_code'           => $seller_order->pickup_code
            ], function ($message) use ($seller)
            {
                $message->to($seller->email)->subject('Your textbook pickup time has been scheduled.');
            });

            return redirect()->back()
                ->withSuccess("You have successfully scheduled the pickup time and we'll email you the details shortly.");
        }

        return redirect('order/seller')
            ->with('message', 'Order not found');
    }

    /**
     * Transfer money of this order to seller's debit card
     */
    public function transfer()
    {
        $seller_order_id    = Input::get('seller_order_id');
        $seller_order       = SellerOrder::find($seller_order_id);

        // TODO: check if this seller order belongs to the current user, or null.
        if (false)
        {
            return redirect('/order/seller')
                ->with('message', 'Order not found.');
        }

        // TODO: check if this seller order is transferred.
        if (false)
        {
            return redirect('/order/seller/'.$seller_order_id)
                ->with('message', 'You have already transferred the balance of this order to your Stripe account.');
        }

        $credential = Auth::user()->stripeAuthorizationCredential;
        // check if this user has a stripe authorization credential
        if (is_null($credential))
        {
            return redirect($this->buildStripeAuthRequestUrl());
        }

        \Stripe\Stripe::setApiKey(StripeKey::getSecretKey());

        $transfer = \Stripe\Transfer::create(array(
            'amount'                => (int)($seller_order->product->price*100),
            'currency'              => Config::get('stripe.currency'),
            'destination'           => $credential->stripe_user_id,
            'application_fee'       => Config::get('stripe.application_fee'),
            'source_transaction'    => $seller_order->buyerOrder->buyer_payment->charge_id, // TODO: test source_transaction after finish create buyer order.
        ));

        return $transfer;
    }

    /**
     * Build and return Stripe Connect account authorize url.
     * @return string
     */
    protected function buildStripeAuthRequestUrl()
    {
        $authorize_request_body = array(
            'response_type' => 'code',
            'scope'         => Config::get('stripe.scope'),
            'client_id'     => StripeKey::getClientId(),
            'state'         => ''   // TODO: for CSRF Protection
        );

        $url = Config::get('stripe.authorize_url') . '?' . http_build_query($authorize_request_body);

        return $url;
    }

}
