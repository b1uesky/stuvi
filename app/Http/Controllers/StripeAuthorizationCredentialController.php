<?php

namespace App\Http\Controllers;

use App\Helpers\StripeKey;
use App\Http\Requests;
use App\StripeAuthorizationCredential;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;

class StripeAuthorizationCredentialController extends Controller
{
//    /**
//     * Display a listing of the resource.
//     *
//     * @return Response
//     */
//    public function index()
//    {
//        //
//    }

//    /**
//     * Show the form for creating a new resource.
//     *
//     * @return Response
//     */
//    public function create()
//    {
//        //
//    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        if (isset($_GET['code']))
        { // Redirect w/ code
            $code = $_GET['code'];

            $token_request_body = array(
                'grant_type'    => 'authorization_code',
                'client_id'     => StripeKey::getClientId(),
                'code'          => $code,
                'client_secret' => StripeKey::getSecretKey(),
            );

            $req = curl_init(Config::get('stripe.token_url'));
            curl_setopt($req, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($req, CURLOPT_POST, true);
            curl_setopt($req, CURLOPT_POSTFIELDS, http_build_query($token_request_body));

            // TODO: Additional error handling
            $respCode = curl_getinfo($req, CURLINFO_HTTP_CODE);
            $resp = json_decode(curl_exec($req), true);
            curl_close($req);

            $credential = StripeAuthorizationCredential::add($resp, Auth::id());

            return redirect()->back();

        }
        else if (isset($_GET['error'])) // Error
        {
            return $_GET['error_description'];
        }
        else
        {
            return Input::all();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        //
    }

//    /**
//     * Show the form for editing the specified resource.
//     *
//     * @param  int  $id
//     * @return Response
//     */
//    public function edit($id)
//    {
//        //
//    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
