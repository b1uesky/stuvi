<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class StoreDonationRequest extends Request
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
            'address_id'            => 'required|exists:addresses,id',
            'scheduled_pickup_time' => 'required|date',
            'quantity'              => 'required|integer|min:1'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'address_id.required' => 'An address is required'
        ];
    }
}
