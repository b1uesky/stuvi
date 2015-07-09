<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Address;
use App\BuyerOrder;
use App\BuyerPayment;
use App\Helpers\StripeKey;
use App\Http\Controllers\Controller;
use App\Product;
use App\SellerOrder;
use Auth;
use Cart;
use Config;
use DB;
use Input;
use Session;
use Mail;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        // validate the address info
        $this->validate($request, Address::rules());

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


        $address->setDefault();
        $default_address_id = $address->id;
        return view('order.buyer.create', [
            'items' => Cart::content(),
            'total' => Cart::total(),
            'stripe_public_key' => StripeKey::getPublicKey(),
            'addresses' => Auth::user()->address,
            'display_payment' => true,
            'default_address_id'=> $default_address_id
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update(Request $request)
    {
        $this->validate($request, Address::rules());

        $address_id = Input::get('address_id');
        $address = Address::find($address_id);
        if ($address->isBelongTo(Auth::id())) {
            $address->update([
                'is_default' => true,
                'addressee' => Input::get('addressee'),
                'address_line1' => Input::get('address_line1'),
                'address_line2' => Input::get('address_line2'),
                'city' => Input::get('city'),
                'state_a2' => Input::get('state_a2'),
                'zip' => Input::get('zip'),
                'phone_number' => Input::get('phone_number')
            ]);

            $address->setDefault();
            $default_address_id = $address->id;
            return view('order.buyer.create', [
                'items' => Cart::content(),
                'total' => Cart::total(),
                'stripe_public_key' => StripeKey::getPublicKey(),
                'addresses' => Auth::user()->address,
                'display_payment' => true,
                'default_address_id'=> $default_address_id
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return Response
     */
    public function ajaxDelete()
    {
        $address_id = Input::get('address_id');
        $address_to_be_deleted = Address::find($address_id);
        if ($address_to_be_deleted->isBelongTo(Auth::id())) {
            $address_to_be_deleted->update([
                'is_default' => false
            ]);
            return response()->json([
                'is_deleted' => $address_to_be_deleted->delete(),
                'num_of_user_addresses' => Auth::user()->address->count()
            ]);
        }

        return response()->json([false]);
    }
}
