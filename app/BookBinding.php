<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class BookBinding extends Model {

    public function book()
    {
        return $this->belongsTo('Book');
    }

}
