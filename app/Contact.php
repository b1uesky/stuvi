<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{

    protected $table = 'contacts';
    protected $guarded = [];

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

    /**
     * Return Y: the contact message is replied.
     * Return N: otherwise.
     *
     * @return string
     */
    public function isReplied()
    {
        if ($this->is_replied)
        {
            return 'Yes';
        }
        else
        {
            return 'No';
        }
    }
}
