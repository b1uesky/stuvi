@extends('textbook')

@section('content')
    <p>Book with isbn {{ $book->isbn }} found in our db.</p>
    <div>
        <p>Title:  {{ $book->title }}</p></br>
        <p>edition {{ $book->edition }}th</p></br>
        <p>Author: {{ $book->author }}</p></br>
        <p>isbn:   {{ $book->isbn }}</p></br>
    </div>
    <a href="{{ url('textbook/sell/product/'.$book->id) }}">Yes, it's the one I have.</a><br>
    <a href="{{ url('textbook/sell/create') }}">No, it's no the one I have.</a>
@endsection