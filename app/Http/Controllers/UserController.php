<?php namespace App\Http\Controllers;


use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class UserController extends Controller {
    
    public function profile(){
        return view('user.profile');
    }

    public function profileEdit(){
        return view('user.profile-edit');
    }

    public function account(){
        return view('user.account');
    }

    public function edit()
    {
        $first_name = Input::get('first_name');
        $last_name  = Input::get('last_name');
        $phone      = Input::get('phone');
        $old_password   = Input::get('old_password');
        $new_password   = Input::get('new_password');

        $user = Auth::user();   // User::find($id)
        $user->first_name   = $first_name;
        $user->save();
    }

}
