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

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['*'];

    /**
     * Get the rules of addressee, street, city, state, zip
     *
     * @return array
     */
    public static function rules() {
        $rules = array(
            'addressee'=>'Max:100',
            'street'=>'required|Max:100',
            'city'=>'required',
            'state_a2'=>'required|Alpha|size:2',
            'zip'=>'required|AlphaDash|Min:5|Max:10', // https://www.barnesandnoble.com/help/cds2.asp?PID=8134
        );

        if(Config::get('addresses::show_country')) {
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

    /**
     * Delete the given address of the user.
     *
     * @param $id  The address id
     * @param $user_id  The user id of the current user.
     * @return bool|null
     */
    public function del($id, $user_id)
    {
        $address = $this->findOrFail($id);

        // check if this address belongs to the user with $user_id
        if ($address->user_id == $user_id) {
            return $address->delete();
        }

        return false;
    }


    public static function add($info, $user_id)
    {
        $address = new Address();
        $address->user_id       = $user_id;
        $address->addressee     = $info['addressee'];
        $address->address_line1 = $info['address_line1'];
        $address->address_line2 = $info['address_line2'];
        $address->city          = $info['city'];
        $address->state_a2      = $info['state_a2'];
        $address->zip           = $info['zip'];
        $address->phone_number  = $info['phone_number'];
        $address->save();

        return $address->id;
    }
}