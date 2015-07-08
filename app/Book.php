<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Book extends Model {

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
     * TODO: order by product general condition
     *
     * @return mixed
     */
    public function availableProducts()
    {
        return $this->products()->where('sold', 0)->get();
//        $products = DB::table('books')
//                        ->join('products', 'books.id', '=', 'products.book_id')
//                        ->join('product_conditions', 'products.id', '=', 'product_conditions.product_id')
//                        ->select('products.*')
//                        ->where('books.id', '=', $this->id)
//                        ->where('products.sold', '=', 0)
//                        ->orderBy('product_conditions.general_condition')
//                        ->get();
    }

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
}
