<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookReminder extends Model
{
    protected $table = 'book_reminders';
    protected $guarded = [];

    public function book()
    {
        return $this->belongsTo('App\Book');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
