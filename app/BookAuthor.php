<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class BookAuthor extends Model
{
    protected $fillable = ['book_id', 'full_name', 'first_name', 'last_name'];

    /**
     * Get the book.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function book()
    {
        return $this->belongsTo('App\Book');
    }
}
