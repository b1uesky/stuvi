<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class BookImageSet extends Model
{

    protected $fillable = ['book_id', 'small_image', 'medium_image', 'large_image'];

    /**
     * Get the book.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function book()
    {
        return $this->belongsTo('Book');
    }

}
