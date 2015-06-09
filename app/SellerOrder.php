<?php namespace App;

use Illuminate\Database\Eloquent\Model;

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
}
