<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class BookImageSet extends Model {

    public function book()
    {
        return $this->belongsTo('Book');
    }

}
