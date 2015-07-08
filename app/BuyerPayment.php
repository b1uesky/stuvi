<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class BuyerPayment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $fillable = ['buyer_order_id', 'amount', 'charge_id', 'card_id', 'object', 'card_last4', 'card_brand', 'card_fingerprint'];

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
