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

    }

    public function updateItem($cart_item_id, $quantity)
    {

    }

    public function content()
    {

    }


    public function clear()
    {

    }

}
