<?php namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Auth;
use Input;
use Mail;
use Session;

class UserController extends Controller
{

    public function overview()
    {
        $user = Auth::user();

        return view('user.overview')->with('num_books_sold', $user->productsSold()->count())->with('num_books_bought', count($user->productsBought()))->with('productsForSale', $user->productsForSale());
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
            $message = 'Your account has already been activated.';
        }
        elseif (Auth::user()->collegeEmail()->verify($code))
        {
            $url     = Input::has('return_to') ? urldecode(Input::get('return_to')) : '/home';
            $message = 'Your account is successfully activated.';
        }
        else
        {
            $url     = '/user/activate';
            $message = 'Sorry, account activation failed because of invalid activation code.';
        }

        return redirect($url)->with('message', $message);
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
            return redirect('/home')->with('Your account has already been activated.');
        }

        $user->sendActivationEmail();

        return redirect('user/activate')->with('message', 'Activation email is sent. Please check your email.');
    }

}
