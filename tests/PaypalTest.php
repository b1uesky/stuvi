<?php
/**
 * Created by PhpStorm.
 * User: Desmond
 * Date: 8/10/15
 * Time: 5:33 PM
 */

use Illuminate\Support\Facades\Config;

class PaypalTest extends TestCase {

    public function testCredentials()
    {
        $flatConfig = array_dot(Config::get('paypal_payment')); // Flatten the array with dots

        Paypalpayment::ApiContext(
            Config::get('paypal_payment.Account.ClientId'),
            Config::get('paypal_payment.Account.ClientSecret')
        )->setConfig($flatConfig);
    }

}