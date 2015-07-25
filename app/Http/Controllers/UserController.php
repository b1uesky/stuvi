<?php namespace App\Http\Controllers;


use App\Profile;
use App\University;
use Auth;
use Input;
use Session;
use Mail;

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
        $user_profile = Profile::where('user_id',$user_id)->get()->toArray();
        $user_school = Auth::user()->university()->get();
        return view('user.profile-edit')
            ->with('profile',$user_profile[0])
            ->with('school',$user_school[0]['name']);
    }

    public function profileStore()
    {
        $user_id = Auth::id();
        $user_profile = Profile::where('user_id',$user_id);
        if ($user_profile->count() > 0){
                $user_profile->update([
                    'user_id'         => $user_id,
                    'sex'             => Input::get('sex'),
                    'birthday'        => Input::get('birth'),
                    'title'           => Input::get('title'),
                    'bio'             => Input::get('bio'),
                    'graduation_date' => Input::get('grad'),
                    'major'           => Input::get('major'),
                    'facebook'        => Input::get('facebook'),
                    'twitter'         => Input::get('twitter'),
                    'linkedin'        => Input::get('linkedin'),
                    'website'         => Input::get('site')
                ]);

                return redirect('user/profile-edit');
        }else{
            Profile::create([
                'user_id'         => $user_id,
                'sex'             => Input::get('sex'),
                'birthday'        => Input::get('birth'),
                'title'           => Input::get('title'),
                'bio'             => Input::get('bio'),
                'graduation_date' => Input::get('grad'),
                'major'           => Input::get('major'),
                'facebook'        => Input::get('facebook'),
                'twitter'         => Input::get('twitter'),
                'linkedin'        => Input::get('linkedin'),
                'website'         => Input::get('site')
            ]);
            return redirect('user/profile-edit');
        }
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

    public function bookshelf()
    {
        return view('user.bookshelf')->with('productsForSale', Auth::user()->productsForSale());
    }

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

    public function resendActivationEmail()
    {
        $user = Auth::user();

        // check if this user has been activated.
        if ($user->isActivated())
        {
            return redirect('/home')
                ->with('Your account has already been activated.');
        }

        // send an email to the user with welcome message
        $user_arr               = $user->toArray();
        $user_arr['university'] = $user->university->toArray();
        $user_arr['return_to']  = urlencode(Session::get('url.intended', '/home'));    // return_to attribute.

        Mail::queue('emails.welcome', ['user' => $user_arr], function($message) use ($user_arr)
        {
            $message->to($user_arr['email'])->subject('Welcome to Stuvi!');
        });

        return redirect('user/activate')
            ->with('message', 'Activation email is sent. Please check your email.');
    }

}
