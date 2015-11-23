<?php namespace App\Helpers;

class Price {
    /**
     * Convert an integer price (cents) to a price with two decimal places.
     *
     * @param integer $price
     * @return string
     */
    public static function convertIntegerToDecimal($price)
    {
        return number_format((float)$price / 100, 2, '.', '');
    }

    /**
     * Convert a decimal price to an integer price (cents).
     *
     * @param decimal $price
     * @return int
     */
    public static function convertDecimalToInteger($price)
    {
        return intval(floatval($price) * 100);
    }

    /**
     * Calculate tax from the total (subtotal + shipping - discount)
     *
     * @param integer $total
     * @return int
     */
    public static function calculateTax($total)
    {
        return intval($total * config('sale.tax'));
    }

    /**
     * Calculate PayPal receiving fee.
     * https://www.paypal.com/webapps/mpp/paypal-fees
     *
     * @param integer $total
     * @return mixed
     */
    public static function calculatePayPalReceivingFee($total)
    {
        return intval($total * 0.029 + 30);
    }

}