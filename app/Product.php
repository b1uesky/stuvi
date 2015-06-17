<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
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

    public function images()
    {
        return $this->hasMany('App\ProductImage');
    }
}