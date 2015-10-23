<?php
/**
 * Created by PhpStorm.
 * User: kingdido999
 * Date: 10/23/15
 * Time: 12:30 PM
 */

namespace App\Helpers;


use Carbon\Carbon;

class DateTime
{
    /**
     * Parse $datetime from database and display it in the view.
     *
     * @param $datetime
     * @return string
     */
    public static function showDatetime($datetime)
    {
        return Carbon::parse($datetime)->format(config('app.datetime_format'));
    }

    public static function saveDatetime($datetime)
    {
        return Carbon::parse($datetime)->format(config('database.datetime_format'));
    }
}