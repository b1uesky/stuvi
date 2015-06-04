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

    public function buyerOrder()
    {
        return $this->belongsTo('App\BuyerOrder');
    }

}
