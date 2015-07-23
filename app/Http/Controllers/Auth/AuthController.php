<?php namespace App\Http\Controllers\Auth;

use App\Email;
use App\Http\Controllers\Controller;
use App\University;
use App\User;
use Auth;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use Input;
use Mail;
use Session;
use Validator;
use Request;
use Response;

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
    protected $redirectAfterLogout  = '/home';
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
            'password'      => bcrypt($data['password']),
            'phone_number'  => preg_replace("/[^0-9 ]/", '', $data['phone_number']),
            'first_name'    => $data['first_name'],
            'last_name'     => $data['last_name'],
        ]);
        $email = Email::create([
            'user_id'       => $user->id,
            'email_address' => $data['email'],
        ]);
        $user->update([
            'primary_email_id'  => $email->id,
        ]);
        $user->assignActivationCode();

        $user->sendActivationEmail();

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
        $v = Validator::make(Input::all(), User::registerRules());

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
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postLogin(Request $request)
    {
        $this->validate($request, User::loginRules());

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        $throttles = $this->isUsingThrottlesLoginsTrait();

        if ($throttles && $this->hasTooManyLoginAttempts($request)) {
            return $this->sendLockoutResponse($request);
        }

        $credentials = $this->getCredentials($request);

        if (Auth::attempt($credentials, $request->has('remember'))) {
            return $this->handleUserWasAuthenticated($request, $throttles);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        if ($throttles) {
            $this->incrementLoginAttempts($request);
        }

        return redirect($this->loginPath())
            ->withInput($request->only($this->loginUsername(), 'remember'))
            ->withErrors([
                $this->loginUsername() => $this->getFailedLoginMessage(),
            ]);
    }

    public function postEmail()
    {
        if (Request::ajax())
        {
            $v = Validator::make(Input::get('email'), [
                 'email'    => 'required|email|max:255|unique:users'
            ]);

            if ($v->fails())
            {
                return Response::json();
            }
        }
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
}
