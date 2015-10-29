<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class StoreAddressRequest extends Request
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
            'addressee'     => 'required|string|Max:100',
            'address_line1' => 'required|string|Max:100',
            'address_line2' => 'string|Max:100',
            'city'          => 'required|string',
            'state_a2'      => 'required|Alpha|size:2',
            'zip'           => 'required|AlphaDash|Min:5|Max:10', // https://www.barnesandnoble.com/help/cds2.asp?PID=8134
            'phone_number'  => 'required|phone:US'
        ];

//        if(config('addresses::show_country')) {
//            $rules['country_a2'] = 'required|Alpha|size:2';
//        }
    }
}
