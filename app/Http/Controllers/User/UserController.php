<?php namespace App\Http\Controllers\User;

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
        $user_profile = Profile::where('user_id',$user_id)->first();
        $user_school = Auth::user()->university;
        return view('user.profile-edit')
            ->with('profile',$user_profile)
            ->with('school',$user_school);
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
            $url = Input::has('return_to') ? urldecode(Input::get('return_to')) : '/home';
            $message = 'Your account has already been activated.';
        }
        elseif (Auth::user()->collegeEmail()->activate($code))
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

}
