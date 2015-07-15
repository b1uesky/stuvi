<?php namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\University;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use App\User;
use Illuminate\Http\Request;
use Input;
use Validator;
use Mail;
use Auth;
use Session;

class AuthController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Registration & Login Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles the registration of new users, as well as the
	| authentication of existing users. By default, this controller uses
	| a simple trait to add these behaviors. Why don't you explore it?
	|
	*/

	use AuthenticatesAndRegistersUsers;

    protected $redirectPath         = '/user/activate';
    protected $redirectAfterLogout  = '/auth/login';
    protected $loginPath            = '/auth/login';

	/**
	 * Create a new authentication controller instance.
	 */
	public function __construct()
	{
		$this->middleware('guest', ['except' => 'getLogout']);
	}

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    public function create(array $data)
    {
        $user = User::create([
            'university_id' => $data['university_id'],
            'email'         => $data['email'],
            'password'      => bcrypt($data['password']),
            'phone_number'  => preg_replace("/[^0-9 ]/", '', $data['phone_number']),
            'first_name'    => $data['first_name'],
            'last_name'     => $data['last_name'],
        ]);
        $user->assignActivationCode();

        // send an email to the user with welcome message
        $user_arr               = $user->toArray();
        $user_arr['university'] = $user->university->toArray();
        $user_arr['return_to']  = urlencode(Session::get('url.intended', '/home'));    // return_to attribute.

        $this->sendActivationEmail($user_arr);

        return $user;
    }

    /**
     * Show the application login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLogin()
    {
        return view('auth.login')
            ->with('loginType', 'login')
            ->with('universities', University::availableUniversities());
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function getRegister()
    {
        return view('auth.login')
            ->with('loginType', 'register')
            ->with('universities', University::availableUniversities());
    }

    /**
     * @override
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  bool  $throttles
     * @return \Illuminate\Http\Response
     */
    protected function handleUserWasAuthenticated(Request $request, $throttles)
    {
        if ($throttles) {
            $this->clearLoginAttempts($request);
        }

        if (method_exists($this, 'authenticated')) {
            return $this->authenticated($request, Auth::user());
        }

        // if the user was redirected from a specific page that needs login or register
        if (Session::has('url.intended'))
        {
            return redirect(Session::pull('url.intended'));
        }

        return redirect()->intended($this->redirectPath());
    }

    /**
     * @override
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postRegister(Request $request)
    {
        // validation
        $v = Validator::make(Input::all(), User::rules());

        $v->after(function($v) {
            $university_id = Input::get('university_id');
            $email = Input::get('email');

            // check whether the email address is matched with the university email suffix.
            if ($university_id && $email && !(University::find($university_id)->matchEmailSuffix($email)))
            {
                $v->errors()->add('email', 'Please use your college email address.');
            }
        });

        if ($v->fails()) {
            $except_fields = ['password'];

            return redirect('/auth/register')
                ->withErrors($v->errors())
                ->withInput(Input::except($except_fields));
        }

        Auth::login($this->create($request->all()));

        return redirect($this->redirectPath());
    }

    /**
     * @override
     *
     * Get the failed login message.
     *
     * @return string
     */
    protected function getFailedLoginMessage()
    {
        return 'Your email and/or password is not correct. Please try again.';
    }

    /**
     * Send an activation email to a given user.
     *
     * @param $user_arr
     */
    protected function sendActivationEmail($user_arr)
    {
        Mail::queue('emails.welcome', ['user' => $user_arr], function($message) use ($user_arr)
        {
            $message->to($user_arr['email'])->subject('Welcome to Stuvi!');
        });
    }
}
