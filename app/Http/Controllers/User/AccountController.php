<?php namespace App\Http\Controllers\User;

/**
 * Created by PhpStorm.
 * User: Tianyou Luo
 * Date: 7/29/15
 * Time: 2:17 PM
 */

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    /**
     * Display the account info page.
     */
    public function index()
    {
        return view('user.account');
    }

    /**
     * Reset the user password.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function passwordReset()
    {
        $validator = Validator::make(Input::all(), User::passwordResetRules());
        if ($validator->fails())
        {
            return back()
                ->with('password_validation_error', $validator->errors());
        }

        $current_password = Input::get('current_password');
        $new_password = Input::get('new_password');

        if (!Hash::check($current_password, Auth::user()->password))
        {
            return back()
                ->with('password_reset_error', 'Incorrect Password.');
        }

        Auth::user()->update([
            'password'  => bcrypt($new_password),
        ]);

        return back()
            ->with('password_reset_success', 'Your password has been reset.');
    }
}