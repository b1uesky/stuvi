<?php
/**
 * Created by PhpStorm.
 * User: Tianyou Luo
 * Date: 6/3/15
 * Time: 2:47 PM
 */

/**
 * NOTE: before migrate the database, modify "laravel-addresses/src/migrations/2014_10_13_105422_create_addresses.php"
 *       1. comment out line 13-17 and add "$table->integer('user_id')->unsigned()->index();".
 *       2. Change "::" in get() method to ".",
 *          e.g. "\Config::get('addresses::default_country')" to "\Config::get('addresses.default_country').
 *
 *       Then run command "php artisan migrate --path=vendor/rtconner/laravel-addresses/src/migrations" to migrate db.
 */

return array(

    // flags that can be linked to addresses
    'flags' => array('primary', 'billing', 'shipping'),

    // whether or not to show country on address view/edit
    'show_country'=>false,

    // Function to fetch currently logged in user. And $callback  to call_user_func is valid.
    //'current_user_func'=>'\Sentry::getUser',
    'current_user_func'=>'Auth::user()',

    // two letter code for the default country you want
    'default_country'=>'US',

    // full name of the default country
    'default_country_name'=>'United States',

    // if this is true, two things happen ..
    // 1. latitude and longitude will be saved into the address table
    // 2. saves run a bit slower because we have to hit google servers
    'geocode'=>false,

    'user'=>array(

        // user model class
        //'model'=>'\Cartalyst\Sentry\Users\Eloquent\User',
        'model'=>'\App\User',

        // Function to fetch currently logged in user. Any valid $callback to call_user_func works here
        //'current'=>'\Sentry::getUser',
        'current'=>'Auth::user()',

    ),

);
