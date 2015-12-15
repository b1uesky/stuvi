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
use App\Http\Requests\CancelBuyerOrderRequest;
use App\Http\Requests\ConfirmDeliveryRequest;
use App\Http\Requests\ScheduleDeliveryRequest;
use App\Http\Requests\ShowBuyerOrderRequest;
use App\Http\Requests\StoreBuyerOrderRequest;
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

        // make sure no item in the cart was sold
        if (!$this->cart->isValid())
        {
            $this->cart->removeSoldItems();

            return redirect('/cart')
                ->with('error', 'One or more items in your cart are sold. Please confirm your items and try again.');
        }

        return view('order.buyer.create')
            ->with('subtotal', $this->cart->subtotal())
            ->with('shipping', $this->cart->shipping())
            ->with('discount', $this->cart->discount())
            ->with('total_before_tax', $this->cart->totalBeforeTax())
            ->with('tax', $this->cart->tax())
            ->with('total', $this->cart->total())
            ->with('items', $this->cart->items);
    }

    /**
     * Display a specific buyer order.
     *
     * @param $request
     * @param BuyerOrder $buyer_order
     *
     * @return Response
     */
    public function show(ShowBuyerOrderRequest $request, $buyer_order)
    {
        return view('order.buyer.show')
            ->with('buyer_order', $buyer_order);
    }

    /**
     * Cancel a specific buyer order and corresponding seller orders.
     *
     * @param $request
     * @param BuyerOrder $buyer_order
     *
     * @return RedirectResponse
     */
    public function cancel(CancelBuyerOrderRequest $request, $buyer_order)
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
     * @param $request
     * @return Response
     */
    public function store(StoreBuyerOrderRequest $request)
    {
        // make sure no item in the cart was sold
        if (!$this->cart->isValid())
        {
            $this->cart->removeSoldItems();

            return redirect('/cart')
                ->with('error', 'One or more items in your cart are sold. Please confirm your items and try again.');
        }

        $shipping_address_id = Input::get('selected_address_id');
        $payment_method = Input::get('payment_method');

        if ($payment_method == 'paypal')
        {
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

            $discount = $this->cart->discount();
            $shipping   = $this->cart->shipping();
            $tax        = $this->cart->tax();

            // We subtract discount from subtotal because PayPal API
            // do not have a param for discount
            $subtotal   = $this->cart->subtotal() - $discount;

            // add discount as a paypal item
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

            // subtotal cannot be less than 0
            if ($subtotal < 0)
            {
                $subtotal = 0;
            }

            // final amount ($subtotal already includes $discount)
            $total = $subtotal + $shipping + $tax;

            $paypal = new Paypal();
            $payment = $paypal->authorizePaymentByPalpal($items, $subtotal, $shipping, $tax, $total, $shipping_address_id);
            $approvalUrl = $payment->getApprovalLink();

            // redirect user to Paypal checkout page
            return Redirect::to($approvalUrl);
        }
        elseif ($payment_method == 'cash')
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
     * @param $request
     * @param BuyerOrder $buyer_order
     * @return $this
     */
    public function scheduleDelivery(ScheduleDeliveryRequest $request, $buyer_order)
    {
        if ($buyer_order->isDeliverySchedulable())
        {
            return view('order.buyer.scheduleDelivery')
                ->with('buyer_order', $buyer_order);
        }
        else
        {
            return redirect()->back()
                ->with('error', 'You cannot update the delivery details for this order.');
        }
    }

    /**
     * Confirm delivery.
     *
     * @param $request
     * @param BuyerOrder $buyer_order
     * @return mixed
     */
    public function confirmDelivery(ConfirmDeliveryRequest $request, $buyer_order)
    {
        if (!$buyer_order->isDeliverySchedulable())
        {
            return redirect()->back()
                ->with('error', 'You cannot update the delivery details for this order.');
        }

        $buyer_order->update([
            'shipping_address_id'       => Input::get('address_id'),
            'scheduled_delivery_time'   => DateTime::saveDatetime(Input::get('scheduled_delivery_time')),
            'delivery_code'             => \App\Helpers\generateRandomNumber(4)
        ]);

        event(new BuyerOrderDeliveryWasScheduled($buyer_order));

        return redirect('order/buyer')
            ->with('success', "You have successfully scheduled the delivery and we'll notify you once your book is on the way.");
    }
}
