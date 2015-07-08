<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\CartItem;

class Cart extends Model
{

    protected $fillable = ['user_id', 'quantity'];

    /**
     * Get the user that this cart belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    /**
     * Delete items in cart by items' id.
     *
     * @param $item_id
     *
     * @internal param $cart_items_id
     */

    public function remove($item_id)
    {
        CartItem::destroy($item_id);

    }

    /**
     * Check whether all items is valid in given cart; Return boolean;
     *
     * @return bool
     * @internal param $cart_id
     */
    public function isValid()
    {
        $cart_items = $this->cartItems();
        foreach ($cart_items as $item) {
            if ($item->product()->isSold()) {
                return false;
            }
        }
        return true;
    }

    /**
     *
     *
     */
    public function validate()
    {
        $cart_items = $this->cartItems();
        foreach ($cart_items as $item) {
            if ($item->product()->isSold()) {
                $this->remove($item->id);
            }

        }

    }


    /**
     * Get all cart items.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cartItems()
    {
        return $this->hasMany('App\CartItem', 'cart_id', 'id');
    }

    public function add(Product $item)
    {
        CartItem::create([
            'cart_id'       => $this->id,
            'product_id'    => $item->id,
        ]);
    }

    public function updateItem($cart_item_id, $quantity)
    {

    }


    public function clear()
    {

    }

    public function total_price()
    {

    }

}
