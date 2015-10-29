<?php

namespace App\Http\Requests;

use App\Address;
use App\Http\Requests\Request;
use Illuminate\Support\Facades\Auth;

class DeleteAddressRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $address_id = $this->get('address_id');

        return Address::where('id', $address_id)
            ->where('user_id', Auth::id())
            ->exists();
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
