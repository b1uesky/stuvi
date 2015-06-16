<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Support\Facades\Auth;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['username', 'email', 'password', 'phone_number', 'first_name', 'last_name', 'activated'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];

    public function buyerOrders()
    {
        return $this->hasMany('App\BuyerOrder', 'buyer_id', 'id');
    }

    public function sellerOrders()
    {
        return $this->hasManyThrough('App\SellerOrder', 'App\Product', 'seller_id', 'product_id');
    }

    // TODO: fulfill productsBought()
    public function productsBought()
    {
        $products = array();

        foreach (BuyerOrder::where('buyer_id', $this->id) as $buyer_order)
        {
            return $buyer_order;
            $products[] += $buyer_order;
//            if (!$buyer_order->cancelled)
//            {
//                foreach ($buyer_order->seller_orders() as $seller_order)
//                {
//                    if (!$seller_order->cancelled)
//                    {
//                        $products[] = $seller_order->product();
//                    }
//                }
//            }
        }

        return $products;

    }

    /**
     * Get all products the current user have sold.
     *
     * @return mixed
     */
    public function productsSold()
    {
        return Product::where('seller_id', $this->id)->where('sold', 1);
    }
}
