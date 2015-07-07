<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\CartItem;

class Cart extends Model
{
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

    public function remove_items($,$cart_items_id) {
        $cart_item =

    }

    public function isValid(){
        $cart_items =  CartItem::where('cart_id','=', )->get();
        foreach ($cart_items as $items) {


        }


    }

    public function validate(){



    }





}
