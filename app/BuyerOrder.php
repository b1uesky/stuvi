<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class BuyerOrder extends Model
{

    protected $table = 'buyer_orders';

    public function buyer()
    {
        return $this->belongsTo('App\User', 'buyer_id', 'id');
    }

    public function shipping_address()
    {
        return $this->belongsTo('App\Address', 'shipping_address_id', 'id');
    }

    /**
     * @return array
     */
    public function products()
    {
        $seller_orders = $this->seller_orders;
        foreach ($seller_orders as $order)
        {
            $products[] = $order->product;
        }
        return $products;

        //return $this->hasManyThrough('App\Product','App\SellerOrder', 'buyer_order_id', 'product_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function seller_orders()
    {
        return $this->hasMany('App\SellerOrder', 'buyer_order_id', 'id');
    }

    /**
     * Check whether this buyer order is belong to a given user.
     *
     * @param $id  A user id
     * @return bool
     */
    public function isBelongTo($id)
    {
        return ($this->buyer_id == $id);
    }

}
