<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Support\Facades\Auth;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{

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

    /**
     * Get all products the current user have post.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany('App\Product', 'seller_id', 'id');
    }

    /**
     * Get all products the current user have bought.
     *
     * @return array
     */
    public function productsBought()
    {
        $products = array();

        foreach ($this->buyerOrders()->get() as $buyer_order)
        {
            if (!$buyer_order->cancelled)
            {
                foreach ($buyer_order->seller_orders()->get() as $seller_order)
                {
                    if (!$seller_order->cancelled)
                    {
                        $products[] = $seller_order->product();
                    }
                }
            }
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
        return $this->products()->where('sold', 1)->get();
    }

    /**
     * Get all products the current user have post but not yet sold.
     *
     * @return mixed
     */
    public function productsForSale()
    {
        return $this->products()->where('sold', 0)->get();
    }

    /**
     * Check if the user has a given role.
     *
     * @param null $role    can be a multi-role string, e.g. ac
     *
     * @return bool
     */
    public function hasRole($role=null)
    {
        if (!is_null($role))
        {
            foreach (str_split($role) as $r)
            {
                if (strpos($this->role, $r) !== false)
                {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Return Yes/No to indicate if the user is activated
     *
     * @return string
     */
    public function isActivated()
    {
        if ($this->activated)
        {
            return 'Yes';
        }

        return 'No';
    }

    public function address()
    {
        return $this->hasMany('App\Address');
    }
}
