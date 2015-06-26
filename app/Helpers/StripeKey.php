<?php namespace App\Helpers;

use Config;

/**
 * Created by PhpStorm.
 * User: Tianyou Luo
 * Date: 6/25/15
 * Time: 2:08 PM
 */

class StripeKey
{
//    public function __construct()
//    {
//        require_once('function.php');
//    }

    /**
     * Get Stripe secret key according to the current app environment.
     *
     * @return string
     */
    public static function getSecretKey()
    {
        return isProductionEnv() ? Config::get('stripe.live_secret_key') : Config::get('stripe.test_secret_key');
    }

    /**
     * Get Stripe public key according to the current app environment.
     *
     * @return string
     */
    public static function getPublicKey()
    {
        return isProductionEnv() ? Config::get('stripe.live_public_key') : Config::get('stripe.test_public_key');
    }

    /**
     * Get Stripe client id according to the current app environment.
     *
     * @return string
     */
    public static function getClientId()
    {
        return isProductionEnv() ? Config::get('stripe.live_client_id') : Config::get('stripe.test_client_id');
    }
}