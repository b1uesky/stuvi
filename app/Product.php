<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Config;

class Product extends Model
{
    protected $fillable = ['price', 'book_id', 'seller_id', 'sold', 'verified'];

    /**
     * Get the book this product belongs to.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function book()
    {
        return $this->belongsTo('App\Book');
    }

    public function seller()
    {
        return $this->belongsTo('App\User');
    }

    public function condition()
    {
        return $this->hasOne('App\ProductCondition');
    }

    /**
     * Return the text description of product's general condition as defined in config/product.php.
     *
     * @return mixed
     */
    public function general_condition()
    {
        return Config::get('product.conditions.general_condition')[$this->condition->general_condition];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function images()
    {
        return $this->hasMany('App\ProductImage');
    }
    /**
     * @return string
     */
    public function isSold2()
    {
        if ($this->sold)
        {
            return 'Yes';
        }

        return 'No';
    }


    /**
     * @return mixed
     *
     */
    public function isSold(){
        return $this->sold;
    }

    /**
     * @return string
     */
    public function isVerified()
    {
        if ($this->verified)
        {
            return 'Yes';
        }

        return 'No';
    }

    /**
     * Validation rules
     *
     * @return array
     */
    public static function rules($extra_images)
    {
        $rules = array(
            'general_condition'     =>  'required|integer',
            'highlights_and_notes'  =>  'required|integer',
            'damaged_pages'         =>  'required|integer',
            'broken_binding'        =>  'required|boolean',
            'price'                 =>  'required|numeric',
            'front-cover-image'     =>  'required|mimes:jpeg,png|max:3072',  // maximum 3MB
            'extra-images'          =>  'mimes:jpeg,png|max:3072'
        );

        return $rules;
    }

    public function generateObjectKey($file)
    {
        $title = implode('-', explode(' ', $this->book->title));

        $key = 'product/' . $title . '-' . $this->id . '.' . $file->getClientOriginalExtension();

        return $key;
    }
}
