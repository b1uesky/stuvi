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
        $config = Config::get('paypal_payment'); // Get all config items as multi dimensional array
        $flatConfig = array_dot($config); // Flatten the array with dots

        Paypalpayment::ApiContext(
            Config::get('paypal_payment.Account.ClientId'),
            Config::get('paypal_payment.Account.ClientSecret')
        )->setConfig($flatConfig);

        $this->assertTrue(true);
    }

}