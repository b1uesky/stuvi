<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class BuyerPayment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $fillable = ['*'];

    /**
     * Get the buyer order.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function buyerOrder()
    {
        return $this->belongsTo('App\BuyerOrder', 'buyer_order_id', 'id');
    }
}
