<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class BookAmazonInfo extends Model {

	public function book()
    {
        return $this->belongsTo('Book');
    }

}
