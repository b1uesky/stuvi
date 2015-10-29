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
     * @param Requests\StoreAddressRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Requests\StoreAddressRequest $request)
    {
        $address = Address::create([
            'user_id'       => Auth::id(),
            'is_default'    => true,
            'addressee'     => $request->get('addressee'),
            'address_line1' => $request->get('address_line1'),
            'address_line2' => $request->get('address_line2'),
            'city'          => $request->get('city'),
            'state_a2'      => $request->get('state_a2'),
            'zip'           => $request->get('zip'),
            'phone_number'  => $request->get('phone_number')
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
//        $address_id = Input::get('address_id');
//        $address = Address::find($address_id);
//        if ($address->isBelongTo(Auth::id())){
//            return Response::json([
//                'success' => true,
//                'address' => $address->toArray()
//            ]);
//        }else{
//            return Response::json([
//                'success' => false,
//                'address'   => 'Address Not Found'
//            ]);
//        }
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
     * @param Requests\UpdateAddressRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Requests\UpdateAddressRequest $request)
    {
        Address::find($request->get('address_id'))
            ->disable();

        $address = Address::create([
            'user_id'       => Auth::id(),
            'is_default'    => true,
            'addressee'     => $request->get('addressee'),
            'address_line1' => $request->get('address_line1'),
            'address_line2' => $request->get('address_line2'),
            'city'          => $request->get('city'),
            'state_a2'      => $request->get('state_a2'),
            'zip'           => $request->get('zip'),
            'phone_number'  => $request->get('phone_number')
        ]);

        $address->setDefault();

        return redirect()->back();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Requests\DeleteAddressRequest $request
     * @return Response
     */
    public function delete(Requests\DeleteAddressRequest $request)
    {
        $address = Address::find($request->get('address_id'));
        $address->disable();

        return redirect()->back();
    }

    /**
     * Set the selected address as default address.
     *
     * @param Requests\SelectAddressRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function select(Requests\SelectAddressRequest $request)
    {
        $selected_address = Address::find($request->get('selected_address_id'));
        $selected_address->setDefault();

        return redirect()->back();
    }
}
