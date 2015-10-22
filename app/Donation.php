<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{

    protected $table = 'donations';
    protected $guarded = [];

    public function donator()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function courier()
    {
        return $this->belongsTo('App\User', 'courier_id');
    }

    public static function rules()
    {
        return [
            'address_id'            => 'required|exists:addresses,id',
            'scheduled_pickup_time' => 'required|date',
            'quantity'              => 'required|integer|min:1'
        ];
    }

}
