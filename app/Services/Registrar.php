<?php namespace App\Services;

use App\User;
use Validator;
use Mail;
use Illuminate\Contracts\Auth\Registrar as RegistrarContract;

class Registrar implements RegistrarContract {

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
			'password' => 'required|min:6', // without |confirmed
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
			'email' => $data['email'],
			'password' => bcrypt($data['password']),
            'phone_number' => $data['phone_number'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
		]);

		Mail::send('emails.welcome', ['first_name' => $data['first_name']], function($message)
		{
		    $message->to('kingdido999@gmail.com', $data['first_name'].$data['last_name'])->subject('Welcome!');
		});

		return $user;
	}

}
