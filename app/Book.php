<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model {

	public function binding()
    {
        return $this->hasOne('App\BookBinding');
    }

    public function imageSet()
    {
        return $this->hasOne('App\BookImageSet');
    }

    public function language()
    {
        return $this->hasOne('App\BookLanguage');
    }

    public function amazonInfo()
    {
        return $this->hasOne('App\BookAmazonInfo');
    }

    public function products()
    {
        return $this->hasMany('App\Product');
    }

}
