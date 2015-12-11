<?php namespace App;

use App\Helpers\Price;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redis;

class Product extends Model
{

    protected $table = 'products';
    protected $guarded = [];

    /*
	|--------------------------------------------------------------------------
	| Relationships
	|--------------------------------------------------------------------------
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

    public function sellerOrders()
    {
        return $this->hasMany('App\SellerOrder');
    }

    public function images()
    {
        return $this->hasMany('App\ProductImage');
    }

    /*
	|--------------------------------------------------------------------------
	| Accessors & Mutators
	|--------------------------------------------------------------------------
	*/

    /**
     * Get product images in html, for admin product images column
     *
     * @return string
     */
    public function getHTMLImagesAttribute()
    {
        $html = '';

        foreach ($this->images as $img) {
            $html .= '<a href="'.$img->getImagePath('large').'" target="__blank"><img src="'.$img->getImagePath('small').'" /></a>';
        }

        return $html;
    }

    public function getVerifiedInStringAttribute()
    {
        return $this->verified ? 'Yes' : 'No';
    }

    public function getSoldInStringAttribute()
    {
        return $this->sold ? 'Yes' : 'No';
    }

    public function getAcceptTradeInInStringAttribute()
    {
        return $this->accept_trade_in ? 'Yes' : 'No';
    }

    public function getPriceAttribute($value)
    {
        return Price::convertIntegerToDecimal($value);
    }

    public function setPriceAttribute($value)
    {
        $this->attributes['price'] = Price::convertDecimalToInteger($value);
    }

    public function getTradeInPriceAttribute($value)
    {
        return Price::convertIntegerToDecimal($value);
    }

    public function setTradeInPriceAttribute($value)
    {
        $this->attributes['trade_in_price'] = Price::convertDecimalToInteger($value);
    }

    public function getRejectedInStringAttribute()
    {
        return $this->is_rejected ? 'Yes' : 'No';
    }

    /*
	|--------------------------------------------------------------------------
	| Query Scopes
	|--------------------------------------------------------------------------
	*/

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
     * @param bool $is_sold
     * @return mixed
     */
    public function scopeSold($query, $is_sold=true)
    {
        return $query->where('sold', '=', $is_sold);
    }

    /**
     * Get products that are deleted.
     *
     * @param $query
     * @param bool|true $is_deleted
     * @return mixed
     */
    public function scopeDeleted($query, $is_deleted=true)
    {
        if ($is_deleted)
        {
            return $query->whereNotNull('deleted_at');
        }
        else
        {
            return $query->whereNull('deleted_at');
        }

    }

    /**
     * Get popular products.
     *
     * @return array
     */
    public function scopePopular()
    {
        // sort a redis list called 'list:product_ids' by
        // product views in desc order
        $popular_product_ids = Redis::sort('list:product_ids', [
            'by'    => 'product:*->views',
            'limit' => [0, 10],
            'sort'  => 'desc'
        ]);

        // map product ids to product objects
        $popular_products = array_map(function($id) {
            return Product::find($id);
        }, $popular_product_ids);

        return $popular_products;
    }

    public function scopeNewProducts($query)
    {
        return $query->sold(false)
            ->availableNow()
            ->orderBy('created_at', 'DESC')
            ->take(8)
            ->get();
    }

    /**
     * Get products that are created after a specific date.
     *
     * @param $query
     * @param $date
     * @return mixed
     */
    public function scopeCreatedAfter($query, $date)
    {
        return $query->where('created_at', '>=', $date);
    }

    /*
	|--------------------------------------------------------------------------
	| Methods
	|--------------------------------------------------------------------------
	*/

    /**
     * Get the number of views.
     *
     * @return mixed
     */
    public function views()
    {
        $views = Redis::hget('product:'.$this->id, 'views');
        return $views ? $views : 0;
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
     * TODO: change name to belongsTo
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
            'price'                 => 'required|numeric|min:'.config('sale.minimum_book_price'),
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
}
