<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class StoreBuyerOrderRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'selected_address_id'   => 'required|exists:addresses,id',
            'payment_method'        => 'required|string|in:paypal,cash'
        ];
    }
}
