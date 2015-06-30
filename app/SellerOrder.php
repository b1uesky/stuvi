<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class SellerOrder extends Model
{
    /**
     * Get the product of this seller order.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo('App\Product');
    }

    public function cancel()
    {
        $this->cancelled = true;
        $this->cancelled_time = Carbon::now();
        $this->product->sold = false;
        $this->push();
    }

    /**
     * Check whether this seller order is belong to a given user.
     *
     * @param $id  A user id
     * @return bool
     */
    public function isBelongTo($id)
    {
        return ($this->product->seller_id == $id);
    }

    /**
     * Return the seller that owns this seller order.
     *
     * @return User
     */
    public function seller()
    {
        return $this->product->seller;
    }

    /**
     * Generate a 4-digit pickup code for the seller order
     * to verify that the courier has picked up the book.
     *
     * This code will be sent to the seller once he/she has
     * scheduled a pickup time.
     *
     * @return int
     */
    public function generatePickupCode()
    {
        $digits = 4;
        $this->pickup_code = rand(pow(10, $digits-1), pow(10, $digits)-1);
        $this->save();
    }

    /**
     * Return if this seller order has been scheduled for pick up
     * It must not be already picked up.
     *
     * @return bool
     */
    public function scheduled()
    {
        return (
            !empty($this->scheduled_pickup_time) &&
            !empty($this->address_id));
    }

    public function pickedUp()
    {
        return !empty($this->pickup_time);
    }

    /**
     * Check if the seller order has been assigned to a courier.
     *
     * @return bool
     */
    public function assignedToCourier()
    {
        return !empty($this->courier_id);
    }

    /**
     * Check if the seller order has been assigned an address
     *
     * @return bool
     */
    public function assignedAddress()
    {
        return !empty($this->address_id);
    }

    /**
     * Return the seller order book.
     *
     * @return Book
     */
    public function book()
    {
        return $this->product->book;
    }

    /**
     * Return the seller order address.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function address()
    {
        return $this->belongsTo('App\Address');
    }

    public function buyerOrder()
    {
        return $this->belongsTo('App\BuyerOrder', 'buyer_order_id', 'id');
    }

    /**
     * Check whether this seller order has been delivered or not
     *
     * @return bool
     */
    public function isDelivered()
    {
        return $this->buyerOrder->delivered();
    }
}
