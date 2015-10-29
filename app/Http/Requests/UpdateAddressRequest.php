<?php

namespace App\Http\Requests;

use App\Address;
use App\Http\Requests\Request;
use Illuminate\Support\Facades\Auth;

class UpdateAddressRequest extends Request
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
            'addressee'     => 'required|string|Max:100',
            'address_line1' => 'required|string|Max:100',
            'address_line2' => 'string|Max:100',
            'city'          => 'required|string',
            'state_a2'      => 'required|Alpha|size:2',
            'zip'           => 'required|AlphaDash|Min:5|Max:10', // https://www.barnesandnoble.com/help/cds2.asp?PID=8134
            'phone_number'  => 'required|phone:US'
        ];
    }
}
