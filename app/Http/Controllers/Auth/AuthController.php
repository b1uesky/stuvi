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
    protected $redirectAfterLogout  = '/login';
    protected $loginPath            = '/login';

	/**
	 * Create a new authentication controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('guest', ['except' => 'getLogout']);
	}

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validator(array $data)
    {
        return Validator::make($data, [
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6',
        ]);
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
        Mail::queue('emails.welcome', ['user' => $user_arr], function($message) use ($data)
        {
            $message->to($data['email'])->subject('Welcome to Stuvi!');
        });

        return $user;
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
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

        // check whether the email address is matched with the university email suffix.
        if (!(University::find(Input::get('university_id'))->matchEmailSuffix(Input::get('email'))))
        {
            return redirect('/register')
                ->with('message', 'You have to use your collage email.');
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
}
