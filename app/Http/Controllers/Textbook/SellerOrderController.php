<?php namespace App\Http\Controllers\Textbook;

use App\Helpers\StripeKey;
use App\Http\Controllers\Controller;
use App\User;
use App\Address;
use App\SellerOrder;
use App\StripeTransfer;

use Log;
use Auth;
use Cart;
use Config;
use DB;
use Input;
use Mail;
use Request;
use Response;
use Session;
use Validator;
use DateTime;
use Carbon\Carbon;
use Aloha\Twilio\Twilio;

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
            ->with('orders',    Auth::user()->sellerOrders()->orderBy($order, 'DESC')->get());
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
    public function cancel($id)
    {
        $seller_order = SellerOrder::find($id);

        // check if this order belongs to the current user.
        if (!is_null($seller_order) && $seller_order->isBelongTo(Auth::id()))
        {
            if ($seller_order->isCancellable())
            {
                $seller_order->cancel();
                return redirect('order/seller/'.$id)
                    ->with('message', 'Your cancel request is submitted. We will process your request in 2 days.');
            }
            else
            {
                return redirect('order/seller/'.$id)
                    ->with('message', 'Sorry, this order is not cancellable.');
            }

            // if the order is assigned to a courier, send a sms to let the courier know
            // that the order has been cancelled
            if ($seller_order->assignedToCourier())
            {
                $this->notifyCourierCancelledOrder($seller_order);
            }

            return redirect('order/seller/' . $id);
        }

        return redirect('order/seller')
            ->with('message', 'Order not found.');
    }

    /**
     * AJAX: set a pickup time for the seller order.
     *
     * @return Json Response
     */
    public function schedulePickupTime()
    {
        if (Request::ajax())
        {
            // validation
            $v = Validator::make(Input::all(), [
                'scheduled_pickup_time' => 'required|date'
            ]);

            if ($v->fails())
            {
                return Response::json([
                    'success' => false,
                    'errors'  => $v->getMessageBag()->toArray()
                ], 400);
            }

            $scheduled_pickup_time = Input::get('scheduled_pickup_time');
            $seller_order_id = Input::get('seller_order_id');
            $seller_order = SellerOrder::find($seller_order_id);

            // check if this seller order belongs to the current user.
            if (!is_null($seller_order) && $seller_order->isBelongTo(Auth::id()))
            {
                // if this seller order is cancelled, user cannot set up pickup time
                if ($seller_order->cancelled)
                {
                    return Response::json([
                        'success' => false,
                        'errors' => [
                            'cancelled' => 'Fail to set pickup time because this order has been cancelled.'
                        ]
                    ], 400);
                }

                $seller_order->scheduled_pickup_time = DateTime::createFromFormat(
                    Config::get('app.datetime_format'), $scheduled_pickup_time)
                    ->format(Config::get('database.datetime_format'));

                $seller_order->save();

                return Response::json([
                    'success' => true,
                    'scheduled_pickup_time' => $scheduled_pickup_time
                ]);
            }

            return Response::json([
                'success' => false,
                'errors' => [
                    'order_not_found' => 'Order not found'
                ]
            ]);
        }
    }

    /**
     * Page for adding a new address.
     *
     * @return \Illuminate\View\View
     */
    public function addAddress($id)
    {
        $seller_order = SellerOrder::find($id);
        return view('order.seller.addAddress')->withSellerOrder($seller_order);
    }

    /**
     * Assign an address for the seller order.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function assignAddress()
    {
        $address_id = Input::get('address_id');
        $seller_order_id = Input::get('seller_order_id');

        $seller_order = SellerOrder::find($seller_order_id);
        $seller_order->address_id = $address_id;
        $seller_order->save();

        return redirect()->back();
    }

    /**
     * Store the new address for seller.
     *
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function storeAddress()
    {
        // validation
        $v = Validator::make(Input::all(), Address::rules());

        if ($v->fails())
        {
            return redirect()->back()->withErrors($v->errors());
        }

        $address = new Address();
        $address->user_id       = Auth::user()->id;
        $address->is_default    = true;
        $address->addressee     = Input::get('addressee');
        $address->address_line1 = Input::get('address_line1');
        $address->address_line2 = Input::get('address_line2');
        $address->city          = Input::get('city');
        $address->state_a2      = Input::get('state_a2');
        $address->zip           = Input::get('zip');
        $address->phone_number  = Input::get('phone_number');
        $address->save();

        $seller_order_id = Input::get('seller_order_id');

        return redirect('order/seller/' . $seller_order_id);
    }

    /**
     * The pickup has been confirmed and send an email to the seller about the pickup details.
     *
     * @param $id
     * @return mixed
     */
    public function confirmPickup($id)
    {
        $seller_order = SellerOrder::find($id);

        // validation: check if pickup time and address has been selected
        $confirm_pickup_errors = array();

        if (!$seller_order->scheduled_pickup_time)
        {
            array_push($confirm_pickup_errors, 'Please schedule a pickup time.');
        }

        if (!$seller_order->address_id)
        {
            array_push($confirm_pickup_errors, 'Please select a pickup address.');
        }

        if (count($confirm_pickup_errors) > 0)
        {
            return redirect()->back()
                ->withConfirmPickupErrors($confirm_pickup_errors);
        }

        // send an email with a verification code to the seller to verify
        // that the courier has picked up the book
        $seller = $seller_order->seller();
        $seller_order->generatePickupCode();

        $seller_order_arr   = $seller_order->allToArray();

        Mail::queue('emails.sellerOrderScheduledPickupTime', [
            'seller_order'            => $seller_order_arr
        ], function ($message) use ($seller)
        {
            $message->to($seller->email)->subject('Your textbook pickup has been scheduled.');
        });

        return redirect()->back()
            ->withSuccess("You have successfully scheduled the pickup and we'll email you the details shortly.");
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

        // check if this seller order is delivered
//        if (!$seller_order->isDelivered())
//        {
//            return redirect('/order/seller/'.$seller_order_id)
//                ->with('message', 'This order is not delivered yet. You can get your money back once the buyer get the book.');
//        }

        $credential = Auth::user()->stripeAuthorizationCredential;
        // check if this user has a stripe authorization credential
        if (empty($credential))
        {
            return redirect($this->buildStripeAuthRequestUrl());
        }

        \Stripe\Stripe::setApiKey(StripeKey::getSecretKey());

        try
        {
            $transfer = \Stripe\Transfer::create(array(
                'amount'                => (int)($seller_order->product->price*100),
                'currency'              => Config::get('stripe.currency'),
                'destination'           => $credential->stripe_user_id,
                'application_fee'       => Config::get('stripe.application_fee'),
                'source_transaction'    => $seller_order->buyerOrder->buyer_payment->charge_id, // TODO: test source_transaction after finish create buyer order.
            ));

            // save this transfer
            $stripe_transfer    = new StripeTransfer;
            $stripe_transfer->seller_order_id   = $seller_order_id;
            $stripe_transfer->transfer_id       = $transfer['id'];
            $stripe_transfer->object            = $transfer['object'];
            $stripe_transfer->amount            = $transfer['amount'];
            $stripe_transfer->currency          = $transfer['currency'];
            $stripe_transfer->status            = $transfer['status'];
            $stripe_transfer->type              = $transfer['type'];
            $stripe_transfer->balance_transaction   = $transfer['balance_transaction'];
            $stripe_transfer->destination       = $transfer['destination'];
            $stripe_transfer->destination_payment   = $transfer['destination_payment'];
            $stripe_transfer->source_transaction    = $transfer['source_transaction'];
            $stripe_transfer->application_fee   = $transfer['application_fee'];
            $stripe_transfer->save();

            return redirect('/order/seller/'.$seller_order_id)
                ->with('message', 'Balance has been transferred to your Stripe account. You can transfer it onto your bank account on Stripe.');

        }
        catch (\Stripe\Error\InvalidRequest $e)
        {
            // Invalid parameters were supplied to Stripe's API
            $error2 = $e->getMessage();
            return redirect()->back()
                ->with('message', 'Sorry, transaction failed. Please contact Stuvi.');
        }
        catch (Exception $e)
        {
            // Something else happened, completely unrelated to Stripe
            $error6 = $e->getMessage();
        }
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

    /**
     * Send a sms to the courier that the order has been cancelled.
     *
     * @param $seller_order
     */
    protected function notifyCourierCancelledOrder($seller_order)
    {
        $twilio = new Twilio(
            Config::get('twilio.twilio.connections.twilio.sid'),
            Config::get('twilio.twilio.connections.twilio.token'),
            Config::get('twilio.twilio.connections.twilio.from')
        );

        $phone_number = $seller_order->courier->phone_number;
        $message = 'Order #' . $seller_order->id . ' has been cancelled by the seller at ' . $seller_order->getCancelledTime();

        $twilio->message($phone_number, $message);
    }
}
