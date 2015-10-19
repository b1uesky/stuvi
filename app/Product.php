<?php namespace App;

use App\Helpers\Price;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'book_id',
        'price',
        'book_id',
        'seller_id',
        'sold',
        'verified',
        'deleted_at',
        'sell_to'
    ];

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

    public function sellerOrders()
    {
        return $this->hasMany('App\SellerOrder');
    }

    public function images()
    {
        return $this->hasMany('App\ProductImage');
    }

    public function isInCart($user_id)
    {
        $cart = Cart::where('user_id', $user_id)
                    ->first();

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
        return config('product.conditions.general_condition')[$this->condition->general_condition];
    }

    /**
     * @return string
     */
    public function isSoldToStr()
    {
        if ($this->sold)
        {
            return 'Yes';
        }

        return 'No';
    }

    /**
     * Check whether this product is belong to a given user.
     *
     * @param $user_id
     *
     * @return bool
     */
    public function isBelongTo($user_id)
    {
        return $this->seller_id == $user_id;
    }

    /**
     * @return mixed
     *
     */
    public function isSold()
    {
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
     * @return string
     */
    public function isRejected()
    {
        if ($this->is_rejected)
        {
            return 'Yes';
        }

        return 'No';
    }

    /**
     * Check whether this product is deleted.
     *
     * @return bool
     */
    public function isDeleted()
    {
        return !is_null($this->deleted_at);
    }

    /**
     * Delete product images from local database and AWS.
     */
    public function deleteImages()
    {
        foreach ($this->images() as $image)
        {
            $image->deleteFromAWS();
        }

        $this->images()->delete();
    }

    /**
     * Return decimal product price.
     *
     * @return string
     */
    public function decimalPrice()
    {
        return Price::convertIntegerToDecimal($this->price);
    }

    /**
     * Validation rules.
     *
     * @param $images
     * @param int $sell_to
     *
     * @return array
     */
    public static function rules($images)
    {
        $rules = [
            'general_condition'     => 'required|integer',
            'highlights_and_notes'  => 'required|integer',
            'damaged_pages'         => 'required|integer',
            'broken_binding'        => 'required|boolean',
            'sell_to'               => 'required|string|in:users,stuvi',
            'price'                 => 'required_if:sell_to,users|numeric|min:0',
            'payout_method'         => 'required|string|in:paypal,cash',
            'paypal'                => 'required_if:payout_method,paypal|email'
        ];

        // validate input images
        foreach (range(0, count($images) - 1) as $index)
        {
            $rules['file' . $index] = 'mimes:jpeg,png|max:5120';
        }

        return $rules;
    }

    /**
     * Validation rules for product edit.
     *
     * @param $images
     * @return array
     */
    public static function rulesUpdate($images)
    {
        $rules = [
            'general_condition'    => 'integer',
            'highlights_and_notes' => 'integer',
            'damaged_pages'        => 'integer',
            'broken_binding'       => 'boolean',
            'price'                => 'required|numeric|min:0',
        ];

        // validate input images
        foreach (range(0, count($images) - 1) as $index) {
            $rules['file' . $index] = 'mimes:jpeg,png|max:5120';
        }

        return $rules;
    }

    /**
     * Build a query for searching products with books title keywords.
     *
     * @param $keywords
     *
     * @return mixed
     */
    public static function buildQueryWithBookTitle($keywords)
    {
        $keywords = explode(' ', $keywords);

        $query = Product::join('books as b', function ($join) use ($keywords)
        {
            $join->on('products.book_id', '=', 'b.id');
            foreach ($keywords as $keyword)
            {
                $join->where('b.title', 'LIKE', '%'.$keyword.'%');
            }
        })->distinct()->select('products.*');

        return $query;
    }

    /**
     * Build a query for searching products sold by keywords.
     *
     * @param $keywords
     *
     * @return mixed
     */
    public static function buildQueryWithSellerName($keywords)
    {
        $keywords = explode(' ', $keywords);

        $query = Product::join('users as u', 'products.seller_id', '=', 'u.id');

        foreach ($keywords as $keyword)
        {
            $query = $query->where(function ($query) use ($keyword)
            {
                $query->where('u.first_name', 'LIKE', $keyword);
                $query->orWhere('u.last_name', 'LIKE', $keyword);
            });
        }

        return $query->distinct()->select('products.*');
    }
}
