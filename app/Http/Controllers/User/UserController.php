<?php namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Profile;
use Auth;
use Input;
use Mail;
use Session;

class UserController extends Controller
{

    public function overview()
    {
        $user = Auth::user();

        return view('user.overview')
            ->with('num_books_sold', $user->productsSold()->count())
            ->with('num_books_bought', count($user->productsBought()))
            ->with('productsForSale', $user->productsForSale());
    }

    public function profile()
    {
        $user = Auth::user();

        return view('user.profile')
            ->withProfile($user->profile);
    }

    public function profileEdit()
    {
        $user_id = Auth::id();
        $user_profile = Profile::find($user_id);

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

        $user = Auth::user();
        $user->first_name = $first_name;
        $user->save();
    }

    /**
     * Display the user's bookshelf (products for sale).
     *
     * @return $this
     */
    public function bookshelf()
    {
        return view('user.bookshelf')->with('productsForSale', Auth::user()->productsForSale());
    }

    /**
     * Activate an account with a code.
     *
     * @param $code
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function activateAccount($code)
    {
        // check if the current user is activated
        if (Auth::user()->isActivated())
        {
            $url     = Input::has('return_to') ? urldecode(Input::get('return_to')) : '/home';

            return redirect($url)
                ->with('error', 'Your account has already been activated.');
        }
        elseif (Auth::user()->collegeEmail()->verify($code))
        {
            $url     = Input::has('return_to') ? urldecode(Input::get('return_to')) : '/home';
            $message = 'Your account has been successfully activated.';

            return redirect($url)
                ->with('success', 'Your account has been successfully activated.');
        }
        else
        {
            $url     = '/user/activate';

            return redirect($url)
                ->with('error', 'Sorry, account activation failed because of an invalid activation code.');
        }
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

        return view('user.waitForActivation')->with('user', Auth::user());
    }

    /**
     * Resend account activation email to user's college email.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resendActivationEmail()
    {
        $user = Auth::user();

        // check if this user has been activated.
        if ($user->isActivated())
        {
            return redirect('/home')->with('error', 'Your account has already been activated.');
        }

        $user->sendActivationEmail();

        return redirect('user/activate')->with('success', 'An activation email has been sent. Please check your email.');
    }
}
