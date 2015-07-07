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
     * @param $cart_items_id
     */

    public function remove($item_id)
    {
        CartItem::destroy($item_id);

    }

    /**
     * Check whether all items is valid in given cart; Return boolean;
     *
     * @param $cart_id
     */
    public function isValid()
    {
        $cart_items = CartItem::where('cart_id', '=', $this->id)->get();
        foreach ($cart_items as $item) {
            if ($this->__validate($item) == false) {
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
        $cart_items =  CartItem::where('cart_id','=',$this->id)->get();
        foreach ($cart_items as $item) {
            if ($this->__validate($item) == false) {
                $this->remove($item->id);
            }

        }
    }

    /**
     * helper function for both isValid() and validate();
     * return bool;
     *
     * @param $item
     * @return bool
     *
     */

    public function __validate($item)
    {
        $product_id = $item->product_id;
        $product = Product::findOrFail($product_id);
        if ($product->isSold() == 'Yes' or $product->isVerified() == 'No') {
            return false;
        }
        return true;

    }







}
