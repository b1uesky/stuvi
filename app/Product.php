<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Config;
use App\Cart;

class Product extends Model
{
    protected $fillable = ['book_id', 'price', 'book_id', 'seller_id', 'sold', 'verified'];

    /**
     * Get the book this product belongs to.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function book()
    {
        return $this->belongsTo('App\Book');
    }

    public function seller()
    {
        return $this->belongsTo('App\User');
    }

    public function condition()
    {
        return $this->hasOne('App\ProductCondition');
    }

    public function isInCart($user_id)
    {
        $cart = Cart::where('user_id', $user_id)->first();

        if ($cart)
        {
            return $cart->hasProduct($this->id);
        }

        return false;
    }



    /**
     * Return the text description of product's general condition as defined in config/product.php.
     *
     * @return mixed
     */
    public function general_condition()
    {
        return Config::get('product.conditions.general_condition')[$this->condition->general_condition];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function images()
    {
        return $this->hasMany('App\ProductImage');
    }
    /**
     * @return string
     */
    public function isSold2()
    {
        if ($this->sold)
        {
            return 'Yes';
        }

        return 'No';
    }


    /**
     * @return mixed
     *
     */
    public function isSold(){
        return $this->sold;
    }

    /**
     * @return string
     */
    public function isVerified()
    {
        if ($this->verified)
        {
            return 'Yes';
        }

        return 'No';
    }


    /**
     * Validation rules.
     *
     * @param $extra_images
     * @return array
     */
    public static function rules($extra_images)
    {
        $rules = array(
            'general_condition'     =>  'required|integer',
            'highlights_and_notes'  =>  'required|integer',
            'damaged_pages'         =>  'required|integer',
            'broken_binding'        =>  'required|boolean',
            'price'                 =>  'required|numeric',
            'front-cover-image'     =>  'required|mimes:jpeg,png|max:3072'  // maximum 3MB
        );

        // validate each image in the input array 'extra-images'
        foreach(range(0, count($extra_images) - 1) as $index) {
            $rules['extra-images.' . $index] = 'mimes:jpeg,png|max:3072';
        }

        return $rules;
    }
}
