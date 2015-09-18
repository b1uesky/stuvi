<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductCondition extends Model
{

    protected $fillable = [
        'general_condition',
        'highlights_and_notes',
        'damaged_pages',
        'broken_binding',
        'description',
        'product_id'
    ];

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
