<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class BuyerOrder extends Model
{

    public function buyer()
    {
        return $this->belongsTo('App\User', 'buyer_id', 'id');
    }

    public function shipping_address()
    {
        return $this->belongsTo('App\Address', 'shipping_address_id', 'id');
    }

}
