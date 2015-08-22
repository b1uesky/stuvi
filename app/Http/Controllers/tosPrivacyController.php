<?php namespace App\Http\Controllers;

class tosPrivacyController extends Controller
{

    public function tos()
    {
        return view('tos');
    }

    public function privacy()
    {
        return view('privacy');
    }

}