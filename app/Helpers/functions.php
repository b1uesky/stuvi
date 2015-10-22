<?php namespace App\Helpers;

/**
 * This file contains common use helper functions.
 *
 * Created by PhpStorm.
 * User: stuvi
 * Date: 6/25/15
 * Time: 2:10 PM
 */

/**
 * Check if the current app environment is production environment.
 *
 * @return bool
 */
function isProductionEnv()
{
    return \App::environment('production');
}

/**
 * Generate a random code with a given length.
 *
 * @param $length How many characters for this code (<= 32)
 *
 * @return string
 */
function generateRandomCode($length)
{
    return substr(md5(uniqid(mt_rand(), true)) , 0, $length);
}

/**
 * Generate a random number with given digits.
 *
 * @param $digits
 * @return int
 */
function generateNumber($digits)
{
    return rand(pow(10, $digits - 1), pow(10, $digits) - 1);
}