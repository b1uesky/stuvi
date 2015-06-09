<?php namespace App\Http\Controllers\Textbook;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;
use App\Address;
use App\Product;
use App\BuyerOrder;
use App\SellerOrder;
use App\BuyerPayment;

use Auth, Input, Cart, Session, DB;

class OrderController extends Controller {

	/**
	 * Display a listing of buyer orders for an user.
	 *
	 * @return Response
	 */
	public function buyerOrderIndex()
	{
        //var_dump(User::find(Auth::id())->orders);
		return view('order.index')->withOrders(User::find(Auth::id())->buyerOrders);
	}

	/**
	 * Show the form for creating a new buyer order along with Stripe payment.
	 *
	 * @return Response
	 */
	public function createBuyerOrder()
	{
		return view('order.createBuyerOrder')->withItems(Cart::content())
                                   ->withTotal(Cart::total());
	}

	/**
	 * Store a newly created buyer order and corresponding seller order(s) in storage.
	 *
	 * @return Response
	 */
	public function storeBuyerOrder(Request $request)
    {
        //return response('check');
        // check if this payment already exist
        if (BuyerPayment::where('stripe_token','=',Input::get('stripeToken'))->exists())
        {
            Session::flash('message', 'Invalid payment.');
            return redirect('/order/createBuyerOrder');
        }
//        // check if all products exist
//        foreach (Cart::content() as $product)
//        if (!(Product::find()->exists()))
//        {
//            return response('Sorry, this product is not exist.');
//        }
        // check if any product in Cart is already traded
        foreach (Cart::content() as $row)
        {
            $product = Product::find($row->id);
            if ($product->sold()) {
                Session::flash('message', 'Sorry,'.$product->book->title.' has been sold. Please remove it from Cart');
                return redirect('/cart');
            }
        }
        //return response('check');
        // create a payment
        $payment = new BuyerPayment;
        $payment->stripe_token      = Input::get('stripeToken');
        $payment->stripe_token_type = Input::get('stripeTokenType');
        $payment->stripe_email      = Input::get('stripeEmail');
        $payment->stripe_amount     = Input::get('stripeAmount');
        $payment->save();

        // store the buyer shipping address
        $address = array(   'addressee'     => Input::get('addressee'),
            'address_line1' => Input::get('address_line1'),
            'address_line2' => Input::get('address_line2'),
            'city'          => Input::get('city'),
            'state_a2'      => Input::get('state_a2'),
            'zip'           => Input::get('zip'),
            'phone_number'  => Input::get('phone_number'));
        $shipping_address_id = Address::add($address, Auth::id());

        // create an buyer payed order
        $order = new BuyerOrder;
        $order->buyer_id            = Auth::id();
        $order->buyer_payment_id    = $payment->id;
        $order->shipping_address_id = $shipping_address_id;
        $order->save();


        // create seller order(s) according to the Cart items
        OrderController::createSellerOrders($order->id);

        // remove payed items from Cart
        Cart::destroy();

        return view('order.storeBuyerOrder')->withOrder($order);
	}

    protected function createSellerOrders($buyer_order_id)
    {
        // create seller order(s) according to the Cart items
        foreach (Cart::content() as $row)
        {
            $product = Product::find($row->id);

            // change the status of the product to be sold.
            $product->sold  = true;
            $product->save();

            // create seller orders
            $order = new SellerOrder;
            $order->product_id      = $product->id;
            $order->buyer_order_id  = $buyer_order_id;
            $order->save();
        }
    }

	/**
	 * Display a specific buyer order.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function showBuyerOrder($id)
	{
		$buyer_order = BuyerOrder::find($id);

        // check if this order belongs to the current user.
        if (!is_null($buyer_order) && $buyer_order->isBelongTo(Auth::id()))
        {
            return view('order.showBuyerOrder')->withBuyerOrder($buyer_order);
        }

        return redirect('order/buyer')->with('message', 'Order not found.');
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
            return view('order.showBuyerOrder')->withBuyerOrder($buyer_order);
        }

        return redirect('order/buyer')->with('message', 'Order not found.');
    }


    /**
     * Display a listing of seller orders for an user.
     *
     * @return Response
     */
    public function sellerOrderIndex()
    {
        return view('order.sellerOrderIndex')->withOrders(User::find(Auth::id())->sellerOrders);
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
            return view('order.showSellerOrder')->withSellerOrder($seller_order);
        }

        return redirect('order/seller')->with('message', 'Order not found');
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
            return view('order.showSellerOrder')->withSellerOrder($seller_order);
        }

        return redirect('order/seller')->with('message', 'Order not found.');
    }

}
