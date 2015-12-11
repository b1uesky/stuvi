<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{

    protected $table = 'carts';
    protected $guarded = [];

    /*
	|--------------------------------------------------------------------------
	| Relationships
	|--------------------------------------------------------------------------
	*/

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
     * Get all cart items.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()
    {
        return $this->hasMany('App\CartItem');
    }

    /*
	|--------------------------------------------------------------------------
	| Methods
	|--------------------------------------------------------------------------
	*/

    /**
     * Get the total price of all items.
     *
     * @return decimal
     */
    public function subtotal()
    {
        $price = 0;

        foreach ($this->items as $cart_item)
        {
            $price += $cart_item->product->price;
        }

        return number_format($price, 2, '.', '');
    }

    /**
     * Get the shipping fee.
     *
     * @return decimal
     */
    public function shipping()
    {
        return config('sale.shipping');
    }

    /**
     * Get the total discount.
     *
     * @return decimal
     */
    public function discount()
    {
        return config('sale.discount');
    }

    /**
     * Get the total tax.
     *
     * @return decimal
     */
    public function tax()
    {
        return round($this->totalBeforeTax() * config('sale.tax'), 2);
    }

    /**
     * Get the total before tax.
     *
     * @return decimal
     */
    public function totalBeforeTax()
    {
        return $this->subtotal() + $this->shipping() - $this->discount();
    }

    /**
     * Get the subtotal of this cart (how much the buyer needs to pay)
     *
     * @return decimal
     */
    public function total()
    {
        return $this->totalBeforeTax() + $this->tax();
    }

    /**
     * Delete items in cart by items' id.
     *
     * @param $product_id
     *
     * @return CartItem|bool
     */
    public function remove($product_id)
    {
        $item = $this->items()->where('product_id', $product_id)->first();

        if ($item)
        {
            $item->delete();
            $this->decrement('quantity');
            $this->save();

            return $item;
        }

        return false;
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
        $this->save();

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
     * Check if cart has the given product.
     *
     * @param $product_id
     *
     * @return bool
     */
    public function hasProduct($product_id)
    {
        return CartItem::where('cart_id', $this->id)
            ->where('product_id', $product_id)
            ->exists();
    }


}
