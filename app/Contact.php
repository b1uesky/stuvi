<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'contacts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'message'];

    /**
     * Validation rules.
     *
     * @return array
     */
    public static function rules()
    {
        return [
            'name'      => 'required|string',
            'email'     => 'required|email',
            'message'   => 'required|string'
        ];
    }
}
