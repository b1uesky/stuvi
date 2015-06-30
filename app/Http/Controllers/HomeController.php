<?php namespace App\Http\Controllers;

use App\University;

class HomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//$this->middleware('auth');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('home');
	}

    public function login() {
        $loginData = ['loginType' => 'login'];
        return view('auth.login')
            ->with($loginData)
            ->with('universities', University::all());
    }

    public function register(){
        $loginData = ['loginType' => 'register'];
        return view('auth.login')
            ->with($loginData)
            ->with('universities', University::all());
    }

    public function about(){
        return view('about');
    }

    public function contact(){
        return view('contact');
    }

}
