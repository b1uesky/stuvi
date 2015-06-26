<?php namespace App\Http\Controllers\Textbook;

use App\Helpers\StripeKey;
use App\Http\Controllers\Controller;
use App\SellerOrder;
use Auth;
use Cart;
use Config;
use DateTime;
use DB;
use Input;
use Session;
use Mail;
use Validator;

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
     * Build and return Stripe Connect account authorize url.
     * @return string
     */
    protected function buildStripeAuthRequestUrl()
    {
        $authorize_request_body = array(
            'response_type' => 'code',
            'scope' => Config::get('stripe.scope'),
            'client_id' => StripeKey::getClientId()
        );

        $url = Config::get('stripe.authorize_url') . '?' . http_build_query($authorize_request_body);

        return $url;
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

            $scheduled_pickup_time = DateTime::createFromFormat("m/d/Y H:i", $scheduled_pickup_time)->format('Y-m-d G:i:s');

            $seller_order->scheduled_pickup_time = $scheduled_pickup_time;
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
//        return Input::all();
//
//        // Set your secret key: remember to change this to your live secret key in production
//        // See your keys here https://dashboard.stripe.com/account/apikeys
//        \Stripe\Stripe::setApiKey(StripeKey::getStripeSecretKey());
//
//        // Get the bank account details submitted by the form
//        $token_id = Input::get('stripeToken');
//        var_dump($token_id);
//        // Create a Recipient
//        $recipient = \Stripe\Recipient::create(array(
//                "name" => Input::get('full_name'),
//                "type" => "individual",
//                "card" => $token_id,
//                "email" => Input::get('email'))
//        );
//
//        return $recipient;

        if (isset($_GET['code'])) { // Redirect w/ code
            $code = $_GET['code'];

            $token_request_body = array(
                'grant_type' => 'authorization_code',
                'client_id' => 'ca_6UbSnyOaMcUW89dZLqr4RGFA9YIfNsxF',
                'code' => $code,
                'client_secret' => 'sk_test_1z2tEIbWtbZVvpWnnzgfymyC'
            );

            $req = curl_init('https://connect.stripe.com/oauth/token');
            curl_setopt($req, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($req, CURLOPT_POST, true );
            curl_setopt($req, CURLOPT_POSTFIELDS, http_build_query($token_request_body));

            // TODO: Additional error handling
            $respCode = curl_getinfo($req, CURLINFO_HTTP_CODE);
            $resp = json_decode(curl_exec($req), true);
            curl_close($req);

            return $resp;

            $account_id = $resp['stripe_user_id'];
            \Stripe\Stripe::setApiKey(StripeKey::getSecretKey());

            return \Stripe\Transfer::create(array(
                'amount'        => 1000,
                'currency'      => 'usd',
                'destination'   => $account_id,
                'application_fee'   => 200,
            ));

        }
        else if (isset($_GET['error'])) // Error
        {
            echo $_GET['error_description'];
        }
    }
}
