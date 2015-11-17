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

    public static function exists($book_id, $user_id)
    {
        return BookReminder::where('book_id', $book_id)
            ->where('user_id', $user_id)
            ->exists();
    }

    public static function getUsersByBookID($book_id)
    {
        $users = [];
        $book_reminders = BookReminder::where('book_id', $book_id)->get();

        foreach ($book_reminders as $br)
        {
            array_push($users, $br->user);
        }

        return $users;
    }
}
