<?php namespace App\Http\Controllers;

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

}
