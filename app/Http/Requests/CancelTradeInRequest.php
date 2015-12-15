<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\SellerOrder;
use Auth;

class CancelTradeInRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $seller_order = SellerOrder::find($this->get('seller_order_id'));
        return $seller_order && $seller_order->belongsToUser(Auth::id());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'seller_order_id'   => 'required|integer|exists:seller_orders,id'
        ];
    }
}
