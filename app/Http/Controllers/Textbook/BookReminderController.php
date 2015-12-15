<?php

namespace App\Http\Controllers\Textbook;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\BookReminder;
use App\Book;
use Auth;

class BookReminderController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $book_id = $request->get('book_id');

        if (Book::where('id', $book_id)->exists())
        {
            BookReminder::create([
                'book_id'   => $book_id,
                'user_id'   => Auth::id()
            ]);

            return redirect()->back()
                ->with('success', 'We will send you an email when this book is available.');
        }

        return redirect()->back()
            ->with('error', 'Sorry, you cannot add a reminder for this book.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $book_reminder = BookReminder::find($id);

        if ($book_reminder)
        {
            $title = $book_reminder->book->title;
            $book_reminder->delete();

            return redirect()->back()
                ->with('success', 'You have removed reminder for textbook: '.$title);
        }
        else
        {
            return redirect()->back()
                ->with('error', 'You cannot remove this reminder');
        }
    }
}
