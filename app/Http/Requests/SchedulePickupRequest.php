<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Auth;

class SchedulePickupRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $seller_order = $this->route('seller_order');
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
            //
        ];
    }
}
