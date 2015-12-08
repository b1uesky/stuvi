<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductCondition extends Model
{

    protected $table = 'product_conditions';
    protected $guarded = [];

    /*
   |--------------------------------------------------------------------------
   | Relationships
   |--------------------------------------------------------------------------
   */

    /**
     * Get the product.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo('App\Product');
    }

    /*
   |--------------------------------------------------------------------------
   | Methods
   |--------------------------------------------------------------------------
   */

    /**
     * Check if it has description.
     *
     * @return bool
     */
    public function hasDescription()
    {
        return $this->description && trim($this->description) != '';
    }

}
