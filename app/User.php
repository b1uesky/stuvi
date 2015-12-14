<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class User extends Model implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract
{

    use Authenticatable, Authorizable, CanResetPassword;

    protected $table = 'users';
    protected $guarded = [];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /*
	|--------------------------------------------------------------------------
	| Relationships
	|--------------------------------------------------------------------------
	*/

    /**
     * Get all buyer orders of this user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function buyerOrders()
    {
        return $this->hasMany('App\BuyerOrder', 'buyer_id', 'id');
    }

    /**
     * Get all seller orders of this user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
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
     * Get all addresses of this user.
     *
     * @return mixed
     */
    public function addresses()
    {
        return $this->hasMany('App\Address')->where('is_enabled', true)
            ->orderBy('created_at', 'desc');
    }

    /**
     * Get the default address of the user.
     *
     * @return mixed
     */
    public function defaultAddress()
    {
        return $this->addresses()->where('is_default', true)->first();
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
                'user_id'  => $this->id,
                'quantity' => 0,
            ]);
        }

        return $this->hasOne('App\Cart', 'user_id', 'id');
    }

    /**
     * Get the user's profile.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function profile()
    {
        if ($this->hasOne('App\Profile')->count() <= 0)
        {
            Profile::create([
                'user_id' => $this->id,
            ]);
        }

        return $this->hasOne('App\Profile');
    }

    /**
     * Get all emails this user has.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
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
     * Get all book reminders that belong to this user.
     *
     * @return  \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bookReminders()
    {
        return $this->hasMany('App\BookReminder', 'user_id');
    }

    /**
     * Get all user referrals that have this user as a reference.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function referrals()
    {
        return $this->hasMany('App\UserReferral', 'reference_user_id');
    }

    /*
	|--------------------------------------------------------------------------
	| Query Scopes
	|--------------------------------------------------------------------------
	*/

    /**
     * Get users who signed up after a specific date.
     *
     * @param $query
     * @param $date
     * @return mixed
     */
    public function scopeSignedUpAfter($query, $date)
    {
        return $query->where('created_at', '>=', $date);
    }

    /*
	|--------------------------------------------------------------------------
	| Methods
	|--------------------------------------------------------------------------
	*/

    /**
     * Get the user primary email address.
     *
     * @return mixed
     */
    public function primaryEmailAddress()
    {
        return $this->primaryEmail->email_address;
    }

    /**
     * Get the college email of this user.
     *
     * @return Email
     */
    public function collegeEmail()
    {
        return $this->emails()->where('email_address', 'like', '%' . $this->university->email_suffix)->first();
    }

    /**
     * Get all products the current user have bought.
     *
     * @return array
     */
    public function productsBought()
    {
        $products = [];

        foreach ($this->buyerOrders as $buyer_order)
        {
            if (!$buyer_order->cancelled)
            {
                foreach ($buyer_order->seller_orders as $seller_order)
                {
                    if (!$seller_order->cancelled)
                    {
                        $products[] = $seller_order->product;
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
        return $this->products()
            ->where('sold', true)
            ->get();
    }

    /**
     * Get all products the current user have post but not yet sold.
     *
     * @return mixed
     */
    public function productsForSale()
    {
        return $this->products()
            ->where('sold', false)
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'DESC')
            ->get();
    }

    /**
     * Check if the user has a given role.
     *
     * @param null $role can be a multi-role string, e.g. ac
     *
     * @return bool
     */
    public function hasRole($role = null)
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
        return $this->collegeEmail()->verified;
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

        if ($email && $email->belongsToUser($this->id) && $email->verified)
        {
            $this->update([
                'primary_email_id' => $email_id,
            ]);

            return $email;
        }

        return false;
    }

    /**
     * @override
     * Get the e-mail address where password reset links are sent.
     *
     * @return string
     */
    public function getEmailForPasswordReset()
    {
        return $this->primaryEmail->email_address;
    }

    /**
     * Get user's full name.
     *
     * @return string
     */
    public function fullName()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * Validation register rules.
     *
     * @return array
     */
    public static function registerRules()
    {
        return [
            'first_name'    => 'required|string',
            'last_name'     => 'required|string',
            'password'      => 'required|min:6',
            'phone_number'  => 'required|phone:US',
            'university_id' => 'required|numeric'
        ];;
    }

    /**
     * Validation login rules.
     *
     * @return array
     */
    public static function loginRules()
    {
        $rules = [
            'password' => 'required|min:6',
        ];

        return array_merge($rules, Email::loginRules());
    }

    public static function passwordResetRules()
    {
        $rules = [
            'current_password' => 'required|min:6',
            'new_password'     => 'required|min:6|confirmed',
        ];

        return $rules;
    }

    public static function updateRules()
    {
        $rules = [
            'first_name'    => 'required|string',
            'last_name'     => 'required|string',
            'phone_number'  => 'required|phone:US',
            'university_id' => 'required|numeric',
            'activated'     => 'required|boolean'
        ];

        return $rules;
    }
}
