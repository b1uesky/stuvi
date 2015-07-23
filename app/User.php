<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

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
    protected $fillable = ['email', 'password', 'phone_number', 'first_name', 'last_name', 'activated', 'university_id', 'activation_code', 'role'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];


    /**
     * Validation rules.
     *
     * @return array
     */
    public static function rules()
    {
        $rules = [
            'first_name'    => 'required|string',
            'last_name'     => 'required|string',
            'email'         => 'required|email|max:255|unique:users',
            'password'      => 'required|min:6',
            'phone_number'  => 'required|phone:US',
            'university_id' => 'required|numeric'
        ];

        return $rules;
    }


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
     * Check if this user is activated.
     *
     * @return bool
     */
    public function isActivated()
    {
        return $this->activated;
    }

    /**
     * Return Yes/No to indicate if the user is activated
     *
     * @return string
     */
    public function isActivated2()
    {
        if ($this->activated)
        {
            return 'Yes';
        }

        return 'No';
    }

    public function addresses()
    {
        return $this->hasMany('App\Address')->where('is_enabled',true);
    }

    /**
     * Get the Stripe authorization credential of this user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function stripeAuthorizationCredential()
    {
        return $this->hasOne('App\StripeAuthorizationCredential', 'user_id', 'id');
    }

    /**
     * Assign an activation code for this user if it is not assigned.
     *
     * @return bool
     */
    public function assignActivationCode()
    {
        if (empty($this->activation_code))
        {
            $this->activation_code = \App\Helpers\generateRandomCode(Config::get('user.activation_code_length'));
            $this->save();
            return true;
        }

        return false;
    }

    public function activate($code)
    {
        if ($code === $this->activation_code)
        {
            $this->update([
                'activated'  => true,
            ]);
//            $this->push();x
            return true;
        }

        return false;
    }

    /**
     * Get the university this user belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function university()
    {
        return $this->belongsTo('App\University', 'university_id', 'id');
    }

    /**
     * Get the user's shopping cart.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function cart()
    {
        if ($this->hasOne('App\Cart')->count() <= 0)
        {
            Cart::create([
                'user_id'   => $this->id,
                'quantity'  => 0,
            ]);
        }

        return $this->hasOne('App\Cart', 'user_id', 'id');
    }

    public function emails()
    {
        return $this->hasMany('App\Email');
    }

    /**
     * Get the user primary email.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function primaryEmail()
    {
        return $this->belongsTo('App\Email', 'primary_email_id');
    }

    /**
     * Set the primary email for user.
     *
     * @param $email_id
     *
     * @return bool|Email
     */
    public function setPrimaryEmail($email_id)
    {
        $email = Email::find($email_id);

        if ($email && $email->isBelongTo($this))
        {
            $this->update([
                'primary_email_id'  => $email_id,
            ]);
            return $email;
        }

        return false;
    }

    /**
     * Get the college email of this user.
     *
     * @return Email
     */
    public function collegeEmail()
    {
        return $this->emails()->where('email_address', 'like', '%'.$this->university->email_suffix)->first();
    }

    /**
     * Send an activation email to a given user.
     */
    public function sendActivationEmail()
    {
        // send an email to the user with welcome message
        $user_arr               = $this->toArray();
        $user_arr['university'] = $this->university->toArray();
        $user_arr['email']      = $this->collegeEmail()->email_address;
        $user_arr['return_to']  = urlencode(Session::get('url.intended', '/home'));    // return_to attribute.

        Mail::queue('emails.welcome', ['user' => $user_arr], function($message) use ($user_arr)
        {
            $message->to($user_arr['email'])->subject('Welcome to Stuvi!');
        });
    }

    /**
     * Get the e-mail address where password reset links are sent.
     *
     * @return string
     */
    public function getEmailForPasswordReset()
    {
        return $this->primaryEmail->email_address;
    }
}
