<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Config;

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
    public function isSold()
    {
        if ($this->sold)
        {
            return 'Yes';
        }

        return 'No';
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
}
