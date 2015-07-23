<?php namespace App\Providers;

/**
 * Created by PhpStorm.
 * User: Tianyou Luo
 * Date: 7/23/15
 * Time: 11:37 AM
 */

use App\Extensions\Auth\EmailUserProvider;
use Illuminate\Auth\Guard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class EmailUserServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        Auth::extend('emailUser', function($app) {
            $provider =  new EmailUserProvider($app['hash'], $app['config']['auth.model']);
            return $provider;
            //return new Guard($provider, $app['session']);
        });
    }
}