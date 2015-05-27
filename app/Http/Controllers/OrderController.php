<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Product;
use App\Order;
use App\BuyerPayment;

use Auth, Input ;

class OrderController extends Controller {

	/**
	 * Display a listing of buyer orders for an user.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('order.index')->withOrders(Order::all());
	}

	/**
	 * Show the form for creating a new order.
	 *
     * @param  int  $id  product_id
	 * @return Response
	 */
	public function create($id)
	{
		return view('order.create')->withProduct(Product::find($id))->withBook(Product::find($id)->book);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
    {
        /* doesn't work even with $fillable set.
        $payment = Payment::create([
            'stripe_token'      => Input::get('stripeToken'),
            'stripe_token_type' => Input::get('stripeTokenType'),
            'stripe_email'      => Input::get('stripeEmail'),
            'stripe_amount'     => Input::get('stripeAmount')
        ]);
        $order = Order::create([
            'product_id'        => Input::get('product_id'),
            'buyer_id'          => Auth::id(),
            'buyer_payment_id'  => $payment->id
        ]);
        */
        // check if this payment already exist
        if (BuyerPayment::where('stripe_token','=',Input::get('stripeToken'))->exists())
        {
            return response('Invalid payment.');
        }
        // check if this product exist
        if (!(Product::find(Input::get('product_id'))->exists()))
        {
            return response('Sorry, this product is not exist.');
        }
        // check if this product is already traded
        if (Product::find(Input::get('product_id'))->sold())
        {
            return response('Sorry, this product has been sold.');
        }

        // create a payment
        $payment = new BuyerPayment;
        $payment->stripe_token      = Input::get('stripeToken');
        $payment->stripe_token_type = Input::get('stripeTokenType');
        $payment->stripe_email      = Input::get('stripeEmail');
        $payment->stripe_amount     = Input::get('stripeAmount');
        $payment->save();

        // create an buyer payed order
        $order = new Order;
        $order->product_id          = Input::get('product_id');
        $order->buyer_id            = Auth::id();
        $order->buyer_payment_id    = $payment->id;
        $order->save();

        // change the status of the product to be traded.
        $order->product->sold = true;
        $order->product->save();

        return view('order.store')->withOrder($order);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
