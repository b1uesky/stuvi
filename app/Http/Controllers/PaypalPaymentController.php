<?php

namespace App\Http\Controllers;

use Anouar\Paypalpayment\PaypalPayment;
use Illuminate\Http\Request;
use Config;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PaypalPaymentController extends Controller
{
    /**
     * object to authenticate the call.
     * @param object $api_context
     */
    private $api_context;

    /**
     * Set the ClientId and the ClientSecret.
     * @param
     *string $client_id
     *string $client_secret
     */
    private $client_id;
    private $client_secret;

    public function __construct()
    {
        $this->client_id = Config::get('paypal_payment.Account.ClientId');
        $this->client_secret = Config::get('paypal_payment.Account.ClientSecret');
        $this->api_context = PaypalPayment::ApiContext($this->client_id, $this->client_secret);

        $flatConfig = array_dot(Config::get('paypal_payment')); // Flatten the array with dots
        $this->api_context->setConfig($flatConfig);
    }


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
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
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
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
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
