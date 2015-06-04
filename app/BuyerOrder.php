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

    /**
     * @return array
     */
    public function products()
    {
        $seller_orders = $this->sellerOrders();
        foreach ($seller_orders as $order)
        {
            $products[] = $order->product;
        }
        return $products;
    }

    public function sellerOrders()
    {
        return $this->hasMany('App\SellerOrder');
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
