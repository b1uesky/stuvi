<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model {

	public function binding()
    {
        return $this->hasOne('BookBinding');
    }

    public function imageSet()
    {
        return $this->hasOne('BookImageSet');
    }

    public function language()
    {
        return $this->hasOne('BookLanguage');
    }

    public function amazonInfo()
    {
        return $this->hasOne('BookAmazonInfo');
    }

    public function products()
    {
        return $this->hasMany('Product');
    }

}
