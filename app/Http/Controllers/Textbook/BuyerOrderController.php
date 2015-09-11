<?php namespace App\Http\Controllers\Textbook;

use App\Address;
use App\BuyerOrder;
use App\Events\BuyerOrderWasCancelled;
use App\Events\BuyerOrderWasPlaced;
use App\Events\SellerOrderWasCreated;
use App\Helpers\Paypal;
use App\Helpers\Price;
use App\Http\Controllers\Controller;
use App\SellerOrder;
use Auth;
use Config;
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
                ->with('error', 'Cannot proceed to checkout because one or more items in your cart are sold. Please press "Update" button.');
        }

        return view('order.buyer.create')
                ->with('subtotal', Price::convertIntegerToDecimal($this->cart->totalPrice()))
                ->with('shipping', Price::convertIntegerToDecimal($this->cart->fee()))
                ->with('discount', Price::convertIntegerToDecimal($this->cart->discount()))
                ->with('tax', Price::convertIntegerToDecimal($this->cart->tax()))
                ->with('total', Price::convertIntegerToDecimal($this->cart->subtotal()))
                ->with('items', $this->cart->items)
                ->with('display_payment', true);
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
            ->with('error', 'Order not found.');
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
                $buyer_order->cancel(Auth::id());

                event(new BuyerOrderWasCancelled($buyer_order));

                return redirect('order/buyer/' . $id)
                    ->with('success', 'Your order has been cancelled.');
            }
            else
            {
                return redirect('order/buyer/' . $id)
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
                'price'         => $item->product->decimalPrice()
            );

            array_push($items, $item_paypal);
        }

        // add discount as an item
        $discount = Price::convertIntegerToDecimal($this->cart->discount());

        array_push($items, array(
            'name'          => 'Discount',
            'description'   => 'Discount',
            'currency'      => 'USD',
            'quantity'      => 1,
            'price'         => - $discount
        ));

        // total price of all items
        $subtotal   = Price::convertIntegerToDecimal($this->cart->totalPrice()) - $discount;
        if ($subtotal < 0)
        {
            $subtotal = 0;
        }
        $shipping   = Price::convertIntegerToDecimal($this->cart->fee());
        $tax        = Price::convertIntegerToDecimal($this->cart->tax());

        // final amount that user will pay
        $total = $subtotal + $shipping + $tax;

        $shipping_address_id = Input::get('selected_address_id');
        $payment_method = Input::get('payment_method');

        if ($payment_method == 'credit_card')
        {
            // prepare credit card info
            $number                 = preg_replace('/[^\d]/', '', Input::get('number')); // digits only
            $type                   = Paypal::getCreditCardType($number);
            $expire_month           = Input::get('expire_month');
            $expire_year            = Paypal::getFullExpireYear(Input::get('expire_year'));
            $cvv                    = Input::get('cvc');
            $name                   = strtoupper(Input::get('name'));
            $first_name             = explode(' ', $name)[0];
            $last_name              = explode(' ', $name)[1];

            // validation
            $v = Validator::make(array(
                'address_id'    => $shipping_address_id,
                'number'        => $number,
                'type'          => $type,
                'expire_month'  => $expire_month,
                'expire_year'   => $expire_year,
                'cvv'           => $cvv,
                'first_name'    => $first_name,
                'last_name'     => $last_name
            ), Paypal::rules());

            if ($v->fails())
            {
                return redirect()->back()
                    ->withErrors($v->errors());
            }

            // Paypal address
            $address = Address::find($shipping_address_id)->toArray();

            // Paypal credit card
            $credit_card = array(
                'type'          => $type,
                'number'        => $number,
                'expire_month'  => $expire_month,
                'expire_year'   => $expire_year,
                'cvv'           => $cvv,
                'first_name'    => $first_name,
                'last_name'     => $last_name
            );

            $paypal = new Paypal();
            $authorization = $paypal->authorizePaymentByCreditCard($address, $credit_card, $items, $subtotal, $shipping, $tax, $total);

            // create buyer order
            $order = BuyerOrder::create([
                'buyer_id'              => Auth::id(),
                'shipping_address_id'   => $shipping_address_id,
                'tax'                   => $this->cart->tax(),
                'fee'                   => $this->cart->fee(),
                'discount'              => $this->cart->discount(),
                'subtotal'              => $this->cart->totalPrice(),
                'amount'                => Price::convertDecimalToInteger($total),
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
        elseif ($payment_method == 'paypal')
        {
            $paypal = new Paypal();
            $payment = $paypal->authorizePaymentByPalpal($items, $subtotal, $shipping, $tax, $total, $shipping_address_id);
            $approvalUrl = $payment->getApprovalLink();

            // redirect user to Paypal checkout page
            return Redirect::to($approvalUrl);
        }
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

        $subtotal = $this->cart->totalPrice();
        $tax = $this->cart->tax();
        $fee = $this->cart->fee();
        $discount = $this->cart->discount();
        $total = $subtotal + $tax + $fee - $discount;

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
            'fee'                   => $fee,
            'discount'              => $discount,
            'amount'                => $total,
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
}
