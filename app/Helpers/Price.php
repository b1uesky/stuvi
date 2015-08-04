<?php namespace App\Helpers;

class Price {
    /**
     * Convert an integer price (cents) to a price with two decimal places.
     *
     * @param integer $price
     * @return string
     */
    public static function ConvertIntegerToDecimal($price)
    {
        return number_format((float)$price / 100, 2, '.', '');
    }

    /**
     * Convert a decimal price to an integer price (cents).
     *
     * @param decimal $price
     * @return int
     */
    public static function ConvertDecimalToInteger($price)
    {
        return intval(floatval($price) * 100);
    }
}