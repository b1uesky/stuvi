<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = ['name', 'email', 'message'];

    public static function rules()
    {
        return [
            'name'      => 'required|string',
            'email'     => 'required|email',
            'message'   => 'required|string'
        ];
    }
}
