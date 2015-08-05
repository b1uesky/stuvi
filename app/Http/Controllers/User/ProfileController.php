<?php namespace App\Http\Controllers\User;

/**
 * Created by PhpStorm.
 * User: Tianyou Luo
 * Date: 7/29/15
 * Time: 2:17 PM
 */

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class ProfileController extends Controller
{
    /**
     * Display the profile page.
     */
    public function index()
    {
        $user         = Auth::user();
        $user_profile = $user->profile;
        $user_school  = $user->university;

        return view('user.profile')->with('profile', $user_profile)->with('school', $user_school);
    }

    /**
     * Update user's profile.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update()
    {
        $user = Auth::user();
        $phone_number = Input::get('phone');
        $phone_number = preg_replace('/[^0-9]+/', '', $phone_number);
        $user->update([
            'first_name'   => Input::get('first_name'),
            'last_name'    => Input::get('last_name'),
            'phone_number' => $phone_number
        ]);

        $user_profile = $user->profile;
        $user_profile->update([
            'sex'             => Input::get('sex'),
            'birthday'        => Input::get('birth'),
            'title'           => Input::get('title'),
            'bio'             => Input::get('bio'),
            'graduation_date' => Input::get('grad'),
            'major'           => Input::get('major'),
            'facebook'        => Input::get('facebook'),
            'twitter'         => Input::get('twitter'),
            'linkedin'        => Input::get('linkedin'),
            'website'         => Input::get('site'),
        ]);

        return redirect('user/profile');
    }
}