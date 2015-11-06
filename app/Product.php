<?php namespace App;

use App\Helpers\Price;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $table = 'products';
    protected $guarded = [];

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

    /**
     * Get products that are available now.
     *
     * @param $query
     * @return mixed
     */
    public function scopeAvailableNow($query)
    {
        return $query->where('available_at', '<=', Carbon::today());
    }

    /**
     * Get products that are available in $num_days days.
     *
     * @param $query
     * @param int $num_days
     * @return mixed
     */
    public function scopeAvailableInDays($query, $num_days)
    {
        return $query->where('available_at', '=', Carbon::today()->addDay($num_days));
    }

    /**
     * Get products that are sold.
     *
     * @param $query
     * @return mixed
     */
    public function scopeSold($query)
    {
        return $query->where('sold', '=', true);
    }

    /**
     * Return the availability of this product. (available now or in x days)
     *
     * @return string
     */
    public function availability()
    {
        $today = Carbon::today();
        $available_date = Carbon::parse($this->available_at);

        if ($available_date <= $today)
        {
            return 'Now';
        }
        else
        {
            return 'In ' . $today->diffInDays($available_date) . ' days';
        }
    }

    public function currentSellerOrder()
    {
        if (count($this->sellerOrders) > 0)
        {
            return $this->sellerOrders->where('cancelled', '=', false)->first();
        }

        return false;
    }

    /**
     * Check if the product is sold to a specific buyer.
     *
     * @param $buyer_id
     * @return bool
     */
    public function isSoldToBuyer($buyer_id)
    {
        $seller_order = $this->currentSellerOrder();

        if ($seller_order)
        {
            return $buyer_id == $seller_order->buyerOrder->buyer_id;
        }

        return false;
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
     * Return decimal trade-in price.
     *
     * @return string
     */
    public function decimalTradeInPrice()
    {
        return Price::convertIntegerToDecimal($this->trade_in_price);
    }

    /**
     * Validation rules.
     *
     * @param $images
     *
     * @return array
     */
    public static function rules($images)
    {
        $rules = [
            'general_condition'     => 'required|integer|in:0,1,2',
            'highlights_and_notes'  => 'required|integer|in:0,1,2',
            'damaged_pages'         => 'required|integer|in:0,1,2',
            'broken_binding'        => 'required|boolean',
            'description'           => 'string',
            'available_at'          => 'required|date',
            'price'                 => 'required|numeric|min:0',
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
