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
     * Get buyer payment of this buyer order.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function buyer_payment()
    {
        return $this->belongsTo('App\BuyerPayment', 'buyer_payment_id', 'id');
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

    /**
     * Cancel this buyer order and corresponding seller orders.
     */
    public function cancel()
    {
        // cancel buyer order
        $this->cancelled = true;
        $this->save();

        // cancel seller orders
        foreach ($this->seller_orders as $seller_order)
        {
            $seller_order->cancel();
        }
    }

}
