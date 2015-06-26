<?php namespace App\Helpers;
/**
 * Created by PhpStorm.
 * User: Tianyou Luo
 * Date: 6/25/15
 * Time: 2:08 PM
 */

class StripeKey
{
    /**
     * Get Stripe secret key according to the current app environment.
     *
     * @return string
     */
    public static function getStripeSecretKey()
    {
        return isProductionEnv() ? Config::get('stripe.live_secret_key') : Config::get('stripe.test_secret_key');
    }

    /**
     * Get Stripe public key according to the current app environment.
     *
     * @return string
     */
    public static function getStripePublicKey()
    {
        return isProductionEnv() ? Config::get('stripe.live_public_key') : Config::get('stripe.test_public_key');
    }
}