<?php namespace App\Http\Controllers;

use App\Product;
use App\University;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class HomeController extends Controller
{

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
        if (Auth::guest())
        {
            return view('home-guest')
                ->with('universities', University::availableUniversities());
        }
        else {
            return view('home-user')
                ->with('popular_products', Product::popular())
                ->with('new_products', Product::newProducts());
        }
    }

    public function about()
    {
        return view('about');
    }

    public function coming()
    {
        return view('coming-soon');
    }
	
}
