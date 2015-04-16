<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['*'];

    public function product()
    {
        return $this->belongsTo('App\Product');
    }

    /* not working
    public function buyer_payment()
    {
        return $this->hasOne('App\BuyerPayment');
    }


    public function seller_payment()
    {
        return $this->hasOne('App\SellerPayment');
    }
    */
}
