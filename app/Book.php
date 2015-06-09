<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model {

    public function imageSet()
    {
        return $this->hasOne('App\BookImageSet');
    }

    public function products()
    {
        return $this->hasMany('App\Product');
    }

}
