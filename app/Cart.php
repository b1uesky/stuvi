<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
     */
    public function remove($item_id)
    {
        $item = CartItem::find($item_id);
        if ($item)
        {
            $item->delete();
            $this->decrement('quantity');
        }
    }

    /**
     * Check whether all items is valid in given cart; Return boolean;
     *
     * @return bool
     * @internal param $cart_id
     */
    public function isValid()
    {
        $cart_items = $this->items();
        foreach ($cart_items as $item) {
            if ($item->product()->isSold()) {
                return false;
            }
        }
        return true;
    }

    /**
     * Remove all sold items in cart.
     */
    public function validate()
    {
        foreach ($this->items as $item) {
            if ($item->product->sold) {
                $this->remove($item->id);
            }
        }
    }

    /**
     * Get all cart items.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()
    {
        return $this->hasMany('App\CartItem');
    }

    /**
     * Add an item into cart.
     *
     * @param Product $item
     *
     * @return CartItem
     */
    public function add(Product $item)
    {
        $cart_item = CartItem::create([
            'cart_id'    => $this->id,
            'product_id' => $item->id,
        ]);

        $this->increment('quantity');

        return $cart_item;
    }

    /**
     * Remove all items from cart.
     */
    public function clear()
    {
        foreach ($this->items as $cart_item)
        {
            $cart_item->delete();
        }

        $this->update([
            'quantity' => 0,
        ]);
    }

    /**
     * Get the total price of all items.
     *
     * @return int
     */
    public function totalPrice()
    {
        $price = 0;

        foreach ($this->items as $cart_item)
        {
            $price += $cart_item->product->price;
        }

        return $price;
    }

    /**
     * Check if cart has the given cart item.
     *
     * @param $item_id
     *
     * @return bool
     */
    public function hasItem($item_id)
    {
        return !$this->items->where('id', intval($item_id))->isEmpty();
    }

    /**
     * Check if cart has the given product.
     *
     * @param $product_id
     *
     * @return bool
     */
    public function hasProduct($product_id)
    {
        return !$this->items->where('product_id', (int)$product_id)->isEmpty();
    }


}
