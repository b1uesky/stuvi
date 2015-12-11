<?php namespace App\Http\Controllers\Textbook;

use App\Address;
use App\BuyerOrder;
use App\Events\BuyerOrderDeliveryWasScheduled;
use App\Events\BuyerOrderWasCancelled;
use App\Events\BuyerOrderWasPlaced;
use App\Events\SellerOrderWasCreated;
use App\Helpers\DateTime;
use App\Helpers\Paypal;
use App\Helpers\Price;
use App\Http\Controllers\Controller;
use App\SellerOrder;
use Auth;
use DB;
use Illuminate\Http\RedirectResponse;
use Input;
use Mail;
use Redirect;
use Session;
use Validator;


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
        $buyer_orders = Auth::user()->buyerOrders()
            ->orderBy('cancelled')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('order.buyer.index')
            ->with('buyer_orders', $buyer_orders);
    }

    /**
     * Show the form for creating a new buyer order along with payment.
     *
     * @return Response
     */
    public function create()
    {
        // if the cart is empty, return to cart page
        if ($this->cart->items->count() < 1)
        {
            return redirect('/cart')
                ->with('error', 'Cannot proceed to checkout because cart is empty.');
        }

        if (!$this->cart->isValid())
        {
            return redirect('/cart')
                ->with('error', 'Cannot proceed to checkout because one or more items in your cart are sold.');
        }

        return view('order.buyer.create')
            ->with('subtotal', number_format($this->cart->subtotal(), 2, '.', ''))
            ->with('shipping', number_format($this->cart->shipping(), 2, '.', ''))
            ->with('discount', number_format($this->cart->discount(), 2, '.', ''))
            ->with('total_before_tax', number_format($this->cart->totalBeforeTax(), 2, '.', ''))
            ->with('tax', number_format($this->cart->tax(), 2, '.', ''))
            ->with('total', number_format($this->cart->total(), 2, '.', ''))
            ->with('items', $this->cart->items);
    }

    /**
     * Display a specific buyer order.
     *
     * @param  BuyerOrder $buyer_order
     *
     * @return Response
     */
    public function show($buyer_order)
    {
        // check if this order belongs to the current user.
        if (!empty($buyer_order) && $buyer_order->isBelongTo(Auth::id()))
        {
            return view('order.buyer.show')
                ->with('buyer_order', $buyer_order);
        }

        return redirect('order/buyer')
            ->with('error', 'Order not found.');
    }

    /**
     * Cancel a specific buyer order and corresponding seller orders.
     *
     * @param BuyerOrder $buyer_order
     *
     * @return RedirectResponse
     */
    public function cancel($buyer_order)
    {
        // check if this order belongs to the current user.
        if ($buyer_order && $buyer_order->isBelongTo(Auth::id()))
        {
            if ($buyer_order->isCancellable())
            {
                $buyer_order->cancel(Auth::id());

                event(new BuyerOrderWasCancelled($buyer_order));

                return redirect('order/buyer/' . $buyer_order->id)
                    ->with('success', 'Your order has been cancelled.');
            }
            else
            {
                return redirect('order/buyer/' . $buyer_order->id)
                    ->with('error', 'Sorry, this order cannot be cancelled.');
            }
        }

        return redirect('order/buyer')
            ->with('error', 'Order not found.');
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

    /**
     * Store a newly created buyer order and corresponding seller order(s) in storage.
     *
     * @return Response
     */
    public function store()
    {
        if (!$this->cart->isValid())
        {
            return redirect('/cart')->with('error', 'Cannot proceed to checkout because one or more items in your cart are sold. Please press "Update" button.');
        }

        $v = Validator::make(Input::all(), BuyerOrder::rules());

        if ($v->fails())
        {
            return redirect()->back()->withErrors($v->errors());
        }

        // Paypal items
        $items = array();

        foreach ($this->cart->items as $item)
        {
            $item_paypal = array(
                'name'          => $item->product->book->title,
                'description'   => $item->product->book->title,
                'currency'      => 'USD',
                'quantity'      => 1,
                'price'         => $item->product->price
            );

            array_push($items, $item_paypal);
        }

        // add discount as an item if necessary
        $discount = $this->cart->discount();

        if ($discount > 0)
        {
            array_push($items, array(
                'name'          => 'Discount',
                'description'   => 'Discount',
                'currency'      => 'USD',
                'quantity'      => 1,
                'price'         => - $discount
            ));
        }

        // total price of all items, including discount item
        $subtotal   = $this->cart->subtotal() - $discount;

        if ($subtotal < 0)
        {
            $subtotal = 0;
        }

        $shipping   = $this->cart->shipping();
        $tax        = $this->cart->tax();

        // final amount that user will pay ($subtotal includes $discount)
        $total = $subtotal + $shipping + $tax;

        $shipping_address_id = Input::get('selected_address_id');
        $payment_method = Input::get('payment_method');

        if ($payment_method == 'paypal')
        {
            $paypal = new Paypal();
            $payment = $paypal->authorizePaymentByPalpal($items, $subtotal, $shipping, $tax, $total, $shipping_address_id);
            $approvalUrl = $payment->getApprovalLink();

            // redirect user to Paypal checkout page
            return Redirect::to($approvalUrl);
        }

        if ($payment_method == 'cash')
        {
            // create buyer order
            $order = BuyerOrder::create([
                'buyer_id'              => Auth::id(),
                'shipping_address_id'   => $shipping_address_id,
                'tax'                   => $this->cart->tax(),
                'shipping'              => $this->cart->shipping(),
                'discount'              => $this->cart->discount(),
                'subtotal'              => $this->cart->subtotal(),
                'amount'                => $this->cart->total(),
                'payment_method'        => $payment_method
            ]);

            // create seller order(s) according to the Cart items
            $this->createSellerOrders($order->id);

            // remove payed items from Cart
            $this->cart->clear();

            // send confirmation email to buyer
            event(new BuyerOrderWasPlaced($order));

            return redirect('/order/confirmation')
                ->with('order', $order);
        }

        //        if ($payment_method == 'credit_card')
//        {
//            // prepare credit card info
//            $number                 = preg_replace('/[^\d]/', '', Input::get('number')); // digits only
//            $type                   = Paypal::getCreditCardType($number);
//            $expire_month           = Input::get('expire_month');
//            $expire_year            = Paypal::getFullExpireYear(Input::get('expire_year'));
//            $cvv                    = Input::get('cvc');
//            $name                   = strtoupper(Input::get('name'));
//            $first_name             = explode(' ', $name)[0];
//            $last_name              = explode(' ', $name)[1];
//
//            // validation
//            $v = Validator::make(array(
//                'address_id'    => $shipping_address_id,
//                'number'        => $number,
//                'type'          => $type,
//                'expire_month'  => $expire_month,
//                'expire_year'   => $expire_year,
//                'cvv'           => $cvv,
//                'first_name'    => $first_name,
//                'last_name'     => $last_name
//            ), Paypal::rules());
//
//            if ($v->fails())
//            {
//                return redirect()->back()
//                    ->withErrors($v->errors());
//            }
//
//            // Paypal address
//            $address = Address::find($shipping_address_id)->toArray();
//
//            // Paypal credit card
//            $credit_card = array(
//                'type'          => $type,
//                'number'        => $number,
//                'expire_month'  => $expire_month,
//                'expire_year'   => $expire_year,
//                'cvv'           => $cvv,
//                'first_name'    => $first_name,
//                'last_name'     => $last_name
//            );
//
//            $paypal = new Paypal();
//            $authorization = $paypal->authorizePaymentByCreditCard($address, $credit_card, $items, $subtotal, $shipping, $tax, $total);
//
//            // create buyer order
//            $order = BuyerOrder::create([
//                'buyer_id'              => Auth::id(),
//                'shipping_address_id'   => $shipping_address_id,
//                'tax'                   => $this->cart->tax(),
//                'shipping'              => $this->cart->shipping(),
//                'discount'              => $this->cart->discount(),
//                'subtotal'              => $this->cart->subtotal(),
//                'amount'                => Price::convertDecimalToInteger($total),
//                'authorization_id'      => $authorization->getId()
//
//            ]);
//
//            // create seller order(s) according to the Cart items
//            $this->createSellerOrders($order->id);
//
//            // remove payed items from Cart
//            $this->cart->clear();
//
//            // send confirmation email to buyer
//            event(new BuyerOrderWasPlaced($order));
//
//            return redirect('/order/confirmation')
//                ->with('order', $order);
//        }
    }

    /**
     * This is the second step required to complete
     * PayPal checkout. Once user completes the payment, paypal
     * redirects the browser to "redirectUrl" provided in the request.
     */
    public function executePayment()
    {
        $payment_id = Input::get('paymentId');
        $payer_id = Input::get('PayerID');
        $shipping_address_id = Input::get('shipping_address_id');

        $subtotal = $this->cart->subtotal();
        $tax = $this->cart->tax();
        $shipping = $this->cart->shipping();
        $discount = $this->cart->discount();
        $total = $subtotal + $tax + $shipping - $discount;

        $paypal = new Paypal();
        $payment = $paypal->executePayment($payment_id, $payer_id);
        $transactions = $payment->getTransactions();
        $relatedResources = $transactions[0]->getRelatedResources();
        $authorization = $relatedResources[0]->getAuthorization();

        // create buyer order
        $order = BuyerOrder::create([
            'buyer_id'              => Auth::id(),
            'shipping_address_id'   => $shipping_address_id,
            'subtotal'              => $subtotal,
            'tax'                   => $tax,
            'shipping'              => $shipping,
            'discount'              => $discount,
            'amount'                => $total,
            'payment_method'        => 'paypal',
            'authorization_id'      => $authorization->getId()
        ]);

        // create seller order(s) according to the Cart items
        $this->createSellerOrders($order->id);

        // remove payed items from Cart
        $this->cart->clear();

        // send confirmation email to buyer
        event(new BuyerOrderWasPlaced($order));

        return redirect('/order/confirmation')
            ->with('order', $order);
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
                'product_id' => $product->id,
                'buyer_order_id' => $buyer_order_id,
            ]);

            // send confirmation email to seller
            event(new SellerOrderWasCreated($order));
        }
    }

    /**
     * Schedule delivery page.
     *
     * @param BuyerOrder $buyer_order
     * @return $this
     */
    public function scheduleDelivery($buyer_order)
    {
        if ($buyer_order->isBelongTo(Auth::id()) && $buyer_order->isDeliverySchedulable())
        {
            return view('order.buyer.scheduleDelivery')
                ->with('buyer_order', $buyer_order);
        }

        return redirect()->back()
            ->with('error', 'You cannot update the delivery details for this order.');
    }

    /**
     * Confirm delivery.
     *
     * @param BuyerOrder $buyer_order
     * @return mixed
     */
    public function confirmDelivery($buyer_order)
    {
        if (!$buyer_order->isBelongTo(Auth::id()) || !$buyer_order->isDeliverySchedulable())
        {
            return redirect()->back()
                ->with('error', 'You cannot update the delivery details for this order.');
        }

        $v = Validator::make(Input::all(), BuyerOrder::confirmDeliveryRules());

        if ($v->fails())
        {
            return redirect()->back()->withErrors($v->errors());
        }

        $buyer_order->update([
            'shipping_address_id'       => Input::get('address_id'),
            'scheduled_delivery_time'   => DateTime::saveDatetime(Input::get('scheduled_delivery_time')),
            'delivery_code'             => \App\Helpers\generateRandomNumber(4)
        ]);

        event(new BuyerOrderDeliveryWasScheduled($buyer_order));

        return redirect('order/buyer')
            ->withSuccess("You have successfully scheduled the delivery and we'll notify you once your book is on the way.");
    }
}
