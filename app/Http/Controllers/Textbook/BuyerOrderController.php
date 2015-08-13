<?php namespace App\Http\Controllers\Textbook;

use App\Address;
use App\BuyerOrder;
use App\BuyerPayment;
use App\Helpers\StripeKey;
use App\Http\Controllers\Controller;
use App\SellerOrder;
use Auth;
use Config;
use DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Input;
use Mail;
use Session;


class BuyerOrderController extends Controller
{

    protected $cart;

    public function __construct()
    {
        if (Auth::user())
        {
            $this->cart = Auth::user()->cart;
        }
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
            ->with('orders', Auth::user()
                                 ->buyerOrders()
                                 ->orderBy($order, 'DESC')
                                 ->get());
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

        $user      = Auth::user();
        $default_address_id = -1;
        $addresses = Address::where('user_id', $user->id)
                            ->where('is_enabled', '1')
                            ->get();
        foreach ($addresses as $address)
        {
            if ($address->is_default == true)
            {
                $default_address_id = $address->id;
            }
        }
        $addresses->toArray();

        if (count($addresses) > 0 && $default_address_id != -1)
        {
            return view('order.buyer.create')
                ->with('items', $this->cart->items)
                ->with('total', $this->cart->subtotal())
                ->with('addresses', $addresses)
                ->with('default_address_id', $default_address_id)
                ->with('display_payment', true)
                ->with('stripe_public_key', StripeKey::getPublicKey());
        }
        else
        {
            return view('order.buyer.create')
                ->with('items', $this->cart->items)
                ->with('total', $this->cart->subtotal())
                ->with('addresses', $addresses)
                ->with('default_address_id', $default_address_id)
                ->with('display_payment', false)
                ->with('stripe_public_key', StripeKey::getPublicKey());
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
            return redirect('/cart')->with('message', 'Cannot proceed to checkout because one or more items in your cart are sold. Please press "Update" button.');
        }

        // create Stripe charge, if it fails, go to checkout page.
        $charge = $this->createBuyerCharge();
        if ($charge instanceof RedirectResponse)
        {
            return $charge;
        }

        $shipping_address_id = Input::get('selected_address_id');

        // create an buyer payed order
        $order = BuyerOrder::create([
                                        'buyer_id'            => Auth::id(),
                                        'shipping_address_id' => $shipping_address_id,
                                        'tax'                 => $this->cart->tax(),
                                        'fee'                 => $this->cart->fee(),
                                        'discount'            => $this->cart->discount(),
                                    ]);

        // create seller order(s) according to the Cart items
        $this->createSellerOrders($order->id);

        // create a payment
        $this->createBuyerPayment($order, $charge);

        // remove payed items from Cart
        $this->cart->clear();

        // send confirmation email to buyer
        $order->emailOrderConfirmation();

        return redirect('/order/confirmation')
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
        $token = Input::get('stripe_token');

        // Create the charge on Stripe's servers - this will charge the user's card
        try
        {
            $charge = \Stripe\Charge::create([
                                                 "amount"      => $this->cart->subtotal(),
                                                 "currency"    => "usd",
                                                 "source"      => $token,
                                                 "name"        => Input::get('name'),
                                                 "description" => "Buyer order payment for buyer order",
                                             ]);

            return $charge;
        }
        catch (\Stripe\Error\Card $e)
        {
            // The card has been declined
            return redirect('/order/create')
                ->with('message', $e->getMessage());
        }
        catch (\Stripe\Error\InvalidRequest $e)
        {
            // Invalid parameters were supplied to Stripe's API
            return redirect('/order/create')
                ->with('message', $e->getMessage());
        }
        catch (\Stripe\Error\Authentication $e)
        {
            // Authentication with Stripe's API failed
            // (maybe you changed API keys recently)
            return redirect('/order/create')
                ->with('message', $e->getMessage());
        }
        catch (\Stripe\Error\ApiConnection $e)
        {
            // Network communication with Stripe failed
            return redirect('/order/create')
                ->with('message', $e->getMessage());
        }
        catch (\Stripe\Error\Base $e)
        {
            // Display a very generic error to the user, and maybe send
            // yourself an email
            return redirect('/order/create')
                ->with('message', $e->getMessage());
        }
        catch (Exception $e)
        {
            // Something else happened, completely unrelated to Stripe
            return redirect('/order/create')
                ->with('message', $e->getMessage());
        }
    }

    /**
     * Create a buyer payment instance.
     *
     * @param $order
     * @param $charge
     *
     * @return static
     */
    protected function createBuyerPayment($order, $charge)
    {
        $payment = BuyerPayment::create([
                                            'buyer_order_id'   => $order->id,
                                            'amount'           => $charge['amount'],
                                            'charge_id'        => $charge['id'],
                                            'card_id'          => $charge['source']['id'],
                                            'object'           => $charge['source']['object'],
                                            'card_last4'       => $charge['source']['last4'],
                                            'card_brand'       => $charge['source']['brand'],
                                            'card_fingerprint' => $charge['source']['fingerprint'],
                                        ]);

        return $payment;
    }

    /**
     * Create seller orders according to a given buyer order.
     *
     * @param $buyer_order_id
     */
    protected function createSellerOrders($buyer_order_id)
    {
        // create seller order(s) according to the Cart items
        foreach ($this->cart->items as $item)
        {
            $product = $item->product;

            // change the status of the product to be sold.
            $product->update([
                                 'sold' => true,
                             ]);

            // update the book price range.
            $product->book->removePrice($product->price);

            // create seller orders
            $order = SellerOrder::create([
                                             'product_id'     => $product->id,
                                             'buyer_order_id' => $buyer_order_id,
                                         ]);

            // send confirmation email to seller
            $order->emailOrderConfirmation();
        }
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
        if ($buyer_order && $buyer_order->isBelongTo(Auth::id()))
        {
            if ($buyer_order->isCancellable())
            {
                $buyer_order->cancel();

                return redirect('order/buyer/' . $id)
                    ->with('message', 'Your cancel request has been submitted. We will process your request in 2 days.');
            }
            else
            {
                return redirect('order/buyer/' . $id)
                    ->with('message', 'Sorry, this order cannot be cancelled. We have picked up one or more books from seller.');
            }
        }

        return redirect('order/buyer')
            ->with('message', 'Order not found.');
    }

    /**
     * Display an order confirmation page.
     *
     * @return RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
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
