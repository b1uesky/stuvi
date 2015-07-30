<?php namespace App\Http\Controllers;

class FAQController extends Controller
{

    public function general()
    {
        return view('faq.general');
    }

    public function orders()
    {
        return view('faq.orders');
    }

    public function account()
    {
        return view('faq.account');
    }

    public function textbook()
    {
        return view('faq.textbook');
    }
}