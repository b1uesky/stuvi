<?php namespace App;

use Illuminate\Database\Eloquent\Model;

use Auth;

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
     * get the rules of addressee, street, city, state, zip
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
}