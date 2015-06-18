<?php namespace App\Http\Controllers\Textbook;

use App\Address;
use App\BuyerOrder;
use App\BuyerPayment;
use App\Http\Controllers\Controller;
use App\Product;
use App\SellerOrder;
use Auth;
use Cart;
use Config;
use DB;
use Illuminate\Http\Request;
use Input;
use Session;

class BuyerOrderController extends Controller
{

    /**
     * Display a listing of buyer orders for an user.
     *
     * @return Response
     */
    public function buyerOrderIndex()
    {
        return view('order.index')
            ->with('orders', Auth::user()->buyerOrders()->orderBy('id')->get());
    }

    /**
     * Show the form for creating a new buyer order along with Stripe payment.
     *
     * @return Response
     */
    public function createBuyerOrder()
    {
        // if the Cart is empty, return to cart page
        if (Cart::content()->count() < 1)
        {
            return redirect('/cart')
                ->with('message', 'Cannot proceed to checkout because Cart is empty.');
        }

        if (!$this->checkCart())
        {
            return redirect('/cart')
                ->with('message', 'Cannot proceed to checkout because you are trying to purchasing your own products.');
        }

        return view('order.createBuyerOrder')
            ->with('items', Cart::content())
            ->with('total', Cart::total());
    }

    /**
     * Store a newly created buyer order and corresponding seller order(s) in storage.
     *
     * @return Response
     */
    public function storeBuyerOrder(Request $request)
    {
        if ($this->checkCart())
        {
            return redirect('/cart')
                ->with('message', 'Cannot proceed to checkout because you are trying to purchasing your own products.');
        }

        // validate the address info
        $this->validate($request, Address::rules());

        // check if this payment already exist
        if (BuyerPayment::where('stripe_token', '=', Input::get('stripeToken'))->exists())
        {
            return redirect('/order/createBuyerOrder')
                ->with('message', 'Invalid payment.');
        }

        // check if any product in Cart is already traded
        foreach (Cart::content() as $row)
        {
            $product = Product::find($row->id);
            if ($product->sold)
            {
                return redirect('/cart')
                    ->with('message', 'Sorry,' . $product->book->title . ' has been sold. Please remove it from Cart');
            }
        }

        // store the buyer shipping address
        $address = array(
            'addressee'     => Input::get('addressee'),
            'address_line1' => Input::get('address_line1'),
            'address_line2' => Input::get('address_line2'),
            'city'          => Input::get('city'),
            'state_a2'      => Input::get('state_a2'),
            'zip'           => Input::get('zip'),
            'phone_number'  => Input::get('phone_number')
        );
        $shipping_address_id = Address::add($address, Auth::id());

        // create an buyer payed order
        $order = new BuyerOrder;
        $order->buyer_id = Auth::id();
        $order->shipping_address_id = $shipping_address_id;
        $order->save();

        // create a payment
        $payment = $this->createBuyerPayment($order);

        // create seller order(s) according to the Cart items
        $this->createSellerOrders($order->id);


        // remove payed items from Cart
        Cart::destroy();

        return redirect('/order/confirmation')
            ->with('order', $order);
    }

    /**
     * Create buyer payment for a given order.
     *
     * @param $order    buyer order
     *
     * @return BuyerPayment|\Illuminate\Http\RedirectResponse
     */
    protected function createBuyerPayment($order)
    {
        // Set your secret key: remember to change this to your live secret key in production
        // See your keys here https://dashboard.stripe.com/account/apikeys
        \Stripe\Stripe::setApiKey(\App::environment('production') ? Config::get('stripe.live_secret_key') : Config::get('stripe.test_secret_key'));

        // Get the credit card details submitted by the form
        $token = Input::get('stripeToken');

        // Create the charge on Stripe's servers - this will charge the user's card
        try
        {
            $charge = \Stripe\Charge::create(array(
                    "amount"      => Cart::total()*100, // amount in cents
                    "currency"    => "usd",
                    "source"      => $token,
                    "description" => "Buyer order payment for buyer order")
            );

            $payment = new BuyerPayment;

            $payment->buyer_order_id    = $order->id;
            $payment->stripe_token  = Input::get('stripeToken');
            $payment->stripe_token_type = Input::get('stripeTokenType');
            $payment->stripe_email  = Input::get('stripeEmail');
            $payment->stripe_amount = Input::get('stripeAmount');
            $payment->save();
            return $payment;
        }
        catch (\Stripe\Error\Card $e)
        {
            // The card has been declined
            return redirect('/order/create')
                ->with('message', 'The card has been declined. Please try another card.');
        }
    }

    protected function createSellerOrders($buyer_order_id)
    {
        // create seller order(s) according to the Cart items
        foreach (Cart::content() as $row)
        {
            $product = Product::find($row->id);

            // change the status of the product to be sold.
            $product->sold = true;
            $product->save();

            // create seller orders
            $order = new SellerOrder;
            $order->product_id = $product->id;
            $order->buyer_order_id = $buyer_order_id;
            $order->save();
        }
    }

    /**
     * Display a specific buyer order.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function showBuyerOrder($id)
    {
        $buyer_order = BuyerOrder::find($id);

        // check if this order belongs to the current user.
        if (!is_null($buyer_order) && $buyer_order->isBelongTo(Auth::id()))
        {
            return view('order.showBuyerOrder')
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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function cancelBuyerOrder($id)
    {
        $buyer_order = BuyerOrder::find($id);

        // check if this order belongs to the current user.
        if (!is_null($buyer_order) && $buyer_order->isBelongTo(Auth::id()))
        {
            $buyer_order->cancel();

            return redirect('order/buyer/' . $id);
        }

        return redirect('order/buyer')
            ->with('message', 'Order not found.');
    }


    /**
     * Display list of seller's unsold books
     *
     */

    public function sellerBookshelfIndex()
    {
        return view('order.sellerBookshelfIndex');
    }

    public function confirmation()
    {
        // check if this page is redirected from storeBuyerOrder method
        if (!Session::has('order'))
        {
            return redirect('/order/buyer');
        }

        return view('order.confirmation');
    }
}
