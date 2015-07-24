<?php namespace App\Http\Controllers;


use App\Email;
use App\Profile;
use Auth;
use Illuminate\Support\Facades\Validator;
use Input;
use Session;
use Mail;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function profile()
    {
        $user = Auth::user();

        return view('user.profile')
            ->with('num_books_sold', $user->productsSold()->count())
            ->with('num_books_bought', count($user->productsBought()))
            ->with('productsForSale', $user->productsForSale());
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
        if (Auth::user()->activated)
        {
            $url = Input::has('return_to') ? urldecode(Input::get('return_to')) : '/home';
            $message = 'Your account has already been activated.';
        }
        elseif (Auth::user()->activate($code))
        {
            $url = Input::has('return_to') ? urldecode(Input::get('return_to')) : '/home';
            $message = 'Your account is successfully activated.';
        }
        else
        {
            $url = '/user/activate';
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

        return view('user.waitForActivation')
            ->with('user', Auth::user());
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
            return redirect('/home')
                ->with('Your account has already been activated.');
        }

        $user->sendActivationEmail();

        return redirect('user/activate')
            ->with('message', 'Activation email is sent. Please check your email.');
    }

    /**
     * Show email setting page.
     */
    public function emailIndex()
    {
        return view('user.email')
            ->with('emails', Auth::user()->emails);
    }

    /**
     * Add an user email.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addEmail()
    {
        $validator = Validator::make(Input::all(), Email::registerRules());
        if ($validator->fails())
        {
            return back()
                ->with('email_validation_error', $validator->errors());
        }


        $email = Email::create([
            'user_id'       => Auth::id(),
            'email_address' => Input::get('email'),
        ]);

        return back();
    }
}
