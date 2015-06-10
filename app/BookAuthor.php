<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class BookAuthor extends Model {

	public function book()
	{
		return $this->belongsTo('App\Book');
	}
}
