<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Product;
use Illuminate\Support\Facades\Auth;

class ShowProductRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $product = $this->route('product');

        // do not show the product if:
        // 1. the product is not verified or
        // 2. the product is sold to someone else
        if (!$product->verified || ($product->isSold() && !$product->isSoldToBuyer(Auth::id())))
        {
            return false;
        }

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
            //
        ];
    }
}
