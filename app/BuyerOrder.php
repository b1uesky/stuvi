<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class BuyerOrder extends Model
{

    protected $table = 'buyer_orders';

    /**
     * Get the buyer of this buyer order.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function buyer()
    {
        return $this->belongsTo('App\User', 'buyer_id', 'id');
    }

    /**
     * Get the shipping address of this buyer order.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function shipping_address()
    {
        return $this->belongsTo('App\Address', 'shipping_address_id', 'id');
    }

    /**
     * Get all products that is belong to this buyer order.
     *
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
    }

    /**
     * Get all seller orders corresponding to this buyer order.
     *
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
     * @param $id  User id
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

    /**
     * Get the corresponding seller order with this buyer order by a given product id
     *
     * @param $id  The product id
     *
     * @return SellerOrder
     */
    public function seller_order($id)
    {
        $seller_orders = $this->seller_orders;

        foreach ($seller_orders as $seller_order)
        {
            if ($seller_order->product_id == (int)$id)
            {
                return $seller_order;
            }
        }

        // this product is not in this buyer order, so there is not seller order for it either.
        // normally, it is impossible to reach here.
        return null;
    }

}
