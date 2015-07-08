<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class BookImageSet extends Model {

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
