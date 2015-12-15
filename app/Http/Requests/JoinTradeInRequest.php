<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Product;
use Illuminate\Support\Facades\Auth;

class JoinTradeInRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $product = Product::find($this->get('product_id'));
        return $product && $product->belongsToUser(Auth::id());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
