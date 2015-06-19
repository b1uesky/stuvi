<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Product;

class Book extends Model {

    public function authors()
    {
        return $this->hasMany('App\BookAuthor');
    }

    public function imageSet()
    {
        return $this->hasOne('App\BookImageSet');
    }

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
        $products = $this->products()->where('sold', 0)->get();
        return $products;
    }


}
