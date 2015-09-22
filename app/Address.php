<?php namespace App;

use Illuminate\Database\Eloquent\Model;

use Auth;
use League\Flysystem\Exception;

/**
 * Created by PhpStorm.
 * User: Tianyou Luo
 * Date: 6/4/15
 * Time: 10:57 AM
 */


class Address extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'addresses';

    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'is_enabled',
        'is_default',
        'addressee',
        'address_line1',
        'address_line2',
        'city' ,
        'state_a2' ,
        'zip',
        'phone_number'
    ];

    /**
     * Get the rules of addressee, street, city, state, zip
     *
     * @return array
     */
    public static function rules() {
        $rules = array(
            'addressee'     => 'required|string|Max:100',
            'address_line1' => 'required|string|Max:100',
            'address_line2' => 'string|Max:100',
            'city'          => 'required|string',
            'state_a2'      => 'required|Alpha|size:2',
            'zip'           => 'required|AlphaDash|Min:5|Max:10', // https://www.barnesandnoble.com/help/cds2.asp?PID=8134
            'phone_number'  => 'required|string'
        );

        if(config('addresses::show_country')) {
            $rules['country_a2'] = 'required|Alpha|size:2';
        }

        return $rules;
    }

    /**
     * Get all shipping addresses of the current user.
     *
     * @return mixed
     */
    public function userAddresses()
    {
        return Address::where('user_id','=',Auth::id());
    }

    public function isBelongTo($user_id)
    {
        return $this->user_id == $user_id;
    }

    /**
     * Set this address as default.
     */
    public function setDefault()
    {
        $stored_addresses = Address::where('user_id',$this -> user_id)->get();

        foreach ($stored_addresses as $user_address) {
            if ($user_address->is_default == true && $user_address->id != $this -> id) {
                $user_address->update([
                    "is_default" => false
                ]);
            }
        }

        $this->update(["is_default" => true]);
    }

    /**
     * Disable this address.
     */
    public function disable()
    {
        $this->update([
            'is_default' => false,
            'is_enabled' => false
        ]);
    }
}