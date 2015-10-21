<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductCondition extends Model
{

    protected $table = 'product_conditions';
    protected $guarded = [];

    /**
     * Get the product.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo('App\Product');
    }

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
