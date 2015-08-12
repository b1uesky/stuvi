<?php
/**
 * Created by PhpStorm.
 * User: Desmond
 * Date: 8/12/15
 * Time: 9:49 AM
 */

namespace App\Helpers;


class Payment
{
    public function __construct()
    {

    }

    /**
     * Return credit card type if number is valid
     * https://developer.paypal.com/webapps/developer/docs/api/#store-a-credit-card
     *
     * @param $number string
     * @return string
     **/
    public static function getCreditCardType($number)
    {
        $number = preg_replace('/[^\d]/', '', $number);

        if (preg_match('/^3[47][0-9]{13}$/', $number))
        {
            return 'amex';
        }
        elseif (preg_match('/^6(?:011|5[0-9][0-9])[0-9]{12}$/', $number))
        {
            return 'discover';
        }
        elseif (preg_match('/^5[1-5][0-9]{14}$/', $number))
        {
            return 'mastercard';
        }
        elseif (preg_match('/^4[0-9]{12}(?:[0-9]{3})?$/', $number))
        {
            return 'visa';
        }
        else
        {
            return 'unknown';
        }
    }

    /**
     * Return credit card expire year in 4 digits, e.g., '18' => '2018'.
     *
     * @param $expire_year
     * @return string
     */
    public static function getFullExpireYear($expire_year)
    {
        if (strlen($expire_year) == 2)
        {
            return '20' . $expire_year;
        }

        return $expire_year;
    }
}