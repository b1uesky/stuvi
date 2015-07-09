<?php namespace App\Http\Controllers\Textbook;

use App\Address;
use App\BuyerOrder;
use App\BuyerPayment;
use App\Helpers\StripeKey;
use App\Http\Controllers\Controller;
use App\Product;
use App\SellerOrder;
use App\User;
use Auth;
//use Cart;
use Config;
use DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Input;
use Session;
use Mail;

class BuyerOrderController extends Controller
{

    protected $cart;

    public function __construct()
    {
        $this->cart = Auth::user()->cart;
    }

    /**
     * For test email functionality
     */
    public function test()
    {
        $user = User::find(7);
        // send an email to the user with welcome message
        $user_arr               = $user->toArray();
        $user_arr['university'] = $user->university->toArray();
        Mail::queue('emails.welcome', ['user' => $user_arr], function($message) use ($user_arr)
        {
            $message->to($user_arr['email'])->subject('Welcome to Stuvi!');
        });
    }

    /**
     * Display a listing of buyer orders for an user.
     *
     * @return Response
     */
    public function index()
    {
        $order = Input::get('ord');
        // check column existence
        $order = $this->hasColumn('buyer_orders', $order) ? $order : 'id';

        return view('order.buyer.index')
            ->with('orders', Auth::user()->buyerOrders()->orderBy($order, 'DESC')->get())
            ->with('datetime_format', Config::get('app.datetime_format'));
    }

    /**
     * Show the form for creating a new buyer order along with Stripe payment.
     *
     * @return Response
     */
    public function create()
    {
        // if the cart is empty, return to cart page
        if ($this->cart->items->count() < 1)
        {
            return redirect('/cart')
                ->with('message', 'Cannot proceed to checkout because cart is empty.');
        }

        if (!$this->cart->isValid())
        {
            return redirect('/cart')
                ->with('message', 'Cannot proceed to checkout because one or more items in your cart are sold. Please press "Update" button.');
        }

        $user = Auth::user();
        $addresses = Address::where('user_id', $user -> id)->get();
        $addresses->toArray();

        if(count($addresses) > 0){
            return view('order.buyer.create')
                ->with('items', $this->cart->items)
                ->with('total', $this->cart->totalPrice())
                ->with('addresses', $addresses)
                ->with('display_payment', true)
                ->with('stripe_public_key', StripeKey::getPublicKey());
        }else{
            return view('order.buyer.create')
                ->with('items', $this->cart->items)
                ->with('total', $this->cart->totalPrice())
                ->with('addresses', $addresses)
                ->with('display_payment', false)
                ->with('stripe_public_key', StripeKey::getPublicKey());
        }
    }

    /**
     * Display a buyer's addresses if has this information in database
     */
    public function storeBuyerAddress(Request $request)
    {
        // validate the address info
        $this->validate($request, Address::rules());

        if (Input::has('address_id'))
        {
            $address_id = Input::get('address_id');
            $address = Address::find($address_id);
            if ($address -> isBelongTo(Auth::id()))
            {
                $address -> update([
                    'is_default' => true,
                    'addressee' => Input::get('addressee'),
                    'address_line1' => Input::get('address_line1'),
                    'address_line2' => Input::get('address_line2'),
                    'city' => Input::get('city'),
                    'state_a2' => Input::get('state_a2'),
                    'zip' => Input::get('zip'),
                    'phone_number' => Input::get('phone_number')
                ]);

                $address -> setDefault();
                return view('order.buyer.create')
                    ->with('items', $this->cart->items)
                    ->with('total', $this->cart->totalPrice())
                    ->with('stripe_public_key', StripeKey::getPublicKey())
                    ->with('addresses',Auth::user()->addresses)
                    ->with('display_payment', true);
//                    ['items' => Cart::content(), 'total' => Cart::total(), 'stripe_public_key' => StripeKey::getPublicKey(), 'addresses' => Auth::user()->address, 'display_payment' => true]);
            }
        }else {
            // store the buyer shipping address
            $address = Address::create([
                'user_id' => Auth::id(),
                'is_default' => true,
                'addressee' => Input::get('addressee'),
                'address_line1' => Input::get('address_line1'),
                'address_line2' => Input::get('address_line2'),
                'city' => Input::get('city'),
                'state_a2' => Input::get('state_a2'),
                'zip' => Input::get('zip'),
                'phone_number' => Input::get('phone_number')
            ]);


            $address -> setDefault();
            return view('order.buyer.create')
                ->with('items', $this->cart->items)
                ->with('total', $this->cart->totalPrice())
                ->with('stripe_public_key', StripeKey::getPublicKey())
                ->with('addresses',Auth::user()->addresses)
                ->with('display_payment', true);

            //    ['items' => Cart::content(), 'total' => Cart::total(), 'stripe_public_key' => StripeKey::getPublicKey(), 'addresses' => Auth::user()->address, 'display_payment' => true]);
        }
    }

    /**
     * Store a newly created buyer order and corresponding seller order(s) in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        if (!$this->cart->isValid())
        {
            return redirect('/cart')
                ->with('message', 'Cannot proceed to checkout because one or more items in your cart are sold. Please press "Update" button.');
        }

        // create Stripe charge, if it fails, go to checkout page.
        $charge = $this->createBuyerCharge();


        $shipping_address_id = Input::get('selected_address_id');

        // create an buyer payed order
        $order                      = new BuyerOrder;
        $order->buyer_id            = Auth::id();
        $order->shipping_address_id = $shipping_address_id;
        $order->save();

        // create seller order(s) according to the Cart items
        $this->createSellerOrders($order->id);

        // create a payment
        $this->createBuyerPayment($order, $charge);

        // remove payed items from Cart
        $this->cart->clear();

        // send confirmation email to buyer
        $this->emailBuyerOrderConfirmation($order);

        return redirect('/order/buyer/confirmation')
            ->with('order', $order);
    }

    /**
     * Create buyer charge with Stripe for a given order.
     *
     * @return BuyerPayment|RedirectResponse
     */
    protected function createBuyerCharge()
    {
        // Set your secret key: remember to change this to your live secret key in production
        // See your keys here https://dashboard.stripe.com/account/apikeys
        \Stripe\Stripe::setApiKey(StripeKey::getSecretKey());

        // Get the credit card details submitted by the form
        $token = Input::get('stripeToken');

        // Create the charge on Stripe's servers - this will charge the user's card
        try
        {
            $charge = \Stripe\Charge::create(array(
                    "amount"      => $this->cart->totalPrice()*100, // amount in cents
                    "currency"    => "usd",
                    "source"      => $token,
                    "description" => "Buyer order payment for buyer order")
            );

            return $charge;
        }
        catch (\Stripe\Error\Card $e)
        {
            // The card has been declined
            return redirect('/order/create')
                ->with('message', 'The card has been declined. Please try another card.');
        }
    }

    protected function createBuyerPayment($order, $charge)
    {
        $payment = BuyerPayment::create([
            'buyer_order_id'    => $order->id,
            'amount'            => $charge['amount'],
            'charge_id'         => $charge['id'],
            'card_id'           => $charge['source']['id'],
            'object'            => $charge['source']['object'],
            'card_last4'        => $charge['source']['last4'],
            'card_brand'        => $charge['source']['brand'],
            'card_fingerprint'  => $charge['source']['fingerprint'],
        ]);

//        $payment->buyer_order_id    = $order->id;
//        $payment->amount            = $charge['amount'];
//        $payment->charge_id         = $charge['id'];
//        $payment->card_id           = $charge['source']['id'];
//        $payment->object            = $charge['source']['object'];
//        $payment->card_last4        = $charge['source']['last4'];
//        $payment->card_brand        = $charge['source']['brand'];
//        $payment->card_fingerprint  = $charge['source']['fingerprint'];
//        $payment->save();

        return $payment;
    }

    protected function createSellerOrders($buyer_order_id)
    {
        // create seller order(s) according to the Cart items
        foreach ($this->cart->items as $item)
        {
            $product = $item->product;

            // change the status of the product to be sold.
            $product->update([
                'sold'  => true,
            ]);

            // create seller orders
            $order = new SellerOrder;
            $order->product_id = $product->id;
            $order->buyer_order_id = $buyer_order_id;
            $order->save();

            // send confirmation email to seller
            $this->emailSellerOrderConfirmation($order);

        }
    }

    /**
     * Email buyer the buyer order confirmation
     *
     * @param BuyerOrder $order
     */
    protected function emailBuyerOrderConfirmation(BuyerOrder $order)
    {
        // convert the buyer order and corresponding objects to an array
        $buyer_order_arr = $order->allToArray();

        Mail::queue('emails.buyerOrderConfirmation', ['buyer_order' => $buyer_order_arr], function($message) use ($order)
        {
            $message->to($order->buyer->email)->subject('Confirmation of your order #'.$order->id);
        });
    }

    /**
     * Email seller the buyer order confirmation
     *
     * @param SellerOrder $order
     */
    protected function emailSellerOrderConfirmation(SellerOrder $order)
    {
        // convert the seller order and corresponding objects to an array
        $seller_order_arr                       = $order->allToArray();

        Mail::queue('emails.sellerOrderConfirmation', ['seller_order'  => $seller_order_arr],
            function($message) use ($order)
        {
            $message->to($order->product->seller->email)->subject('Your book '.$order->product->book->title.' has sold!' );
        });
    }

    /**
     * Display a specific buyer order.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $buyer_order = BuyerOrder::find($id);

        // check if this order belongs to the current user.
        if (!empty($buyer_order) && $buyer_order->isBelongTo(Auth::id()))
        {
            return view('order.buyer.show')
                ->with('buyer_order', $buyer_order)
                ->with('datetime_format', Config::get('app.datetime_format'));
        }

        return redirect('order/buyer')
            ->with('message', 'Order not found.');
    }

    /**
     * Cancel a specific buyer order and corresponding seller orders.
     *
     * @param $id  The buyer order id.
     *
     * @return RedirectResponse
     */
    public function cancel($id)
    {
        $buyer_order = BuyerOrder::find($id);

        // check if this order belongs to the current user.
        if (!is_null($buyer_order) && $buyer_order->isBelongTo(Auth::id()))
        {
            if ($buyer_order->cancellable())
            {
                $buyer_order->cancel();
                return redirect('order/buyer/' . $id)
                    ->with('message', 'Your cancel request is submitted. We will process your request in 2 days.');
            }
            else
            {
                return redirect('order/seller/'.$id)
                    ->with('message', 'Sorry, this order is not cancellable. We have picked up one or more books from seller.');
            }
        }

        return redirect('order/buyer')
            ->with('message', 'Order not found.');
    }

    public function confirmation()
    {
        // check if this page is redirected from storeBuyerOrder method
        if (!Session::has('order'))
        {
            return redirect('/order/buyer');
        }

        return view('order.buyer.confirmation');
    }
}
