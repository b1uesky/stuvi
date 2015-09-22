<?php

namespace App\Http\Controllers;

use App\Address;
use App\Http\Requests;
use Auth;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Input;
use Mail;
use Session;
use Validator;

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
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $v = Validator::make(Input::all(), Address::rules());

        if ($v->fails())
        {
            return redirect()->back()->withErrors($v->errors());
        }

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

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  Request $request
     *
     * @return Response
     */
    public function show(Request $request)
    {
        $address_id = Input::get('address_id');
        $address = Address::find($address_id);
        if ($address->isBelongTo(Auth::id())){
            return Response::json([
                'success' => true,
                'address' => $address->toArray()
            ]);
        }else{
            return Response::json([
                'success' => false,
                'address'   => 'Address Not Found'
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request)
    {
        $v = Validator::make(Input::all(), Address::rules());

        if ($v->fails())
        {
            return redirect()->back()->withErrors($v->errors());
        }

        $address_id = Input::get('address_id');
        $address = Address::find($address_id);

        if ($address->isBelongTo(Auth::id())) {
            $address->disable();

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

            return redirect()->back();
        }
        else
        {
            return redirect()->back()->withError('Cannot edit the address.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return Response
     */
    public function delete()
    {
        $address_id = Input::get('address_id');
        $address_to_be_deleted = Address::find($address_id);

        if ($address_to_be_deleted->isBelongTo(Auth::id())) {
            $address_to_be_deleted->disable();

            return redirect()->back();
        }

        return response()->back()->withError('Cannot delete the address.');
    }

    /**
     * Set the selected address as default address.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function select()
    {
        $selected_address = Address::find(Input::get('selected_address_id'));

        if ($selected_address)
        {
            $selected_address->setDefault();
            return redirect()->back();
        }
        else
        {
            return redirect()->back()->withError('The address you selected does not exist.');
        }
    }
}
