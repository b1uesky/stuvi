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
 * @return mixed
 */
function isProductionEnv()
{
    return \App::environment('production');
}