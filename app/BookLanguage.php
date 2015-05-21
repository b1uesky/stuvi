<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class BookLanguage extends Model {

    public function book()
    {
        return $this->belongsTo('Book');
    }

}
