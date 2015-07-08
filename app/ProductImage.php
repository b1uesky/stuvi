<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model {

    /**
     * Get the product.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
	public function product()
	{
		return $this->belongsTo('App\Product');
	}
}
