<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class BookAuthor extends Model
{

    protected $table = 'book_authors';
    protected $guarded = [];

    /*
	|--------------------------------------------------------------------------
	| Relationships
	|--------------------------------------------------------------------------
	*/

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
