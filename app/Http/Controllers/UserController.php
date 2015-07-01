<?php namespace App\Http\Controllers;


use Auth, Input;
use Illuminate\Support\Facades\Config;

class UserController extends Controller
{

    public function profile()
    {
        $user   = Auth::user();

        return view('user.profile')
            ->with('num_books_sold', $user->productsSold()->count())
            ->with('num_books_bought', count($user->productsBought()))
            ->with('productsForSale', $user->productsForSale());
    }

    public function profileEdit()
    {
        return view('user.profile-edit');
    }

    public function account()
    {
        return view('user.account');
    }

    public function edit()
    {
        $first_name = Input::get('first_name');
        $last_name = Input::get('last_name');
        $phone = Input::get('phone');
        $old_password = Input::get('old_password');
        $new_password = Input::get('new_password');

        $user = Auth::user();   // User::find($id)
        $user->first_name = $first_name;
        $user->save();
    }

    public function bookshelf()
    {
        return view('user.bookshelf')->with('productsForSale', Auth::user()->productsForSale());
    }

    public function activateAccount($code)
    {
        // check if the current user is activated
        if (Auth::user()->activated)
        {
            $url        = '/home';
            $message    = 'Your account has already been activated.';
        }
        elseif (Auth::user()->activate($code))
        {
            $url        = '/home';
            $message = 'Your account is successfully activated.';
        }
        else
        {
            $url        = '/user/activate';
            $message = 'Sorry, account activation failed because of invalid activation code.';
        }
        return redirect($url)
            ->with('message', $message);
    }

    /**
     * After registering an account, it will redirect to this page waiting for activation.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function waitForActivation()
    {
        if (Auth::user()->isActivated())
        {
            return redirect('/home');
        }

        return view('user.waitForActivation');
    }

}
