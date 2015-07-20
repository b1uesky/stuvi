<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Book extends Model
{

    protected $fillable = ['title', 'edition', 'isbn10', 'isbn13', 'num_pages', 'verified', 'binding', 'language',
                            'list_price', 'lowest_new_price', 'lowest_used_price'];

    /**
     * Validation rules
     *
     * @return array
     */
    public static function rules()
    {
        $rules = array(
            'isbn'      =>  'required|unique:books',
            'title'     =>  'required|string',
            'authors'   =>  'required|string',
            'edition'   =>  'required|integer',
            'num_pages' =>  'required|integer',
            'binding'   =>  'required|string',
            'language'  =>  'required|string',
            'image'     =>  'required|mimes:jpeg,png|max:3000'
        );

        return $rules;
    }

    /**
     * Get textbook authors
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function authors()
    {
        return $this->hasMany('App\BookAuthor');
    }

    /**
     * Get textbook image set
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function imageSet()
    {
        return $this->hasOne('App\BookImageSet');
    }

    /**
     * Get textbook products
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany('App\Product');
    }

    /**
     * Get all products of this book that are not sold yet.
     *
     * @return mixed
     */
    public function availableProducts()
    {
        $products = $this->products()
            ->where('sold', 0)
            ->join('product_conditions as cond', 'products.id', '=', 'cond.product_id')
            ->orderBy('cond.general_condition')
            ->select('products.*')
            ->get();

        return $products;
    }

}
