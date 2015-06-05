@extends('textbook')

@section('content')
    <div class="container">
        <div class="row">
            <div>
                <p>ISBN:  {{ $book->isbn }}</p>
                <p>Title:  {{ $book->title }}</p>
                <p>edition {{ $book->edition }}th</p>
                <p>Author: {{ $book->author }}</p>
            </div>

            <a href="{{ url('textbook/sell/product/create/'.$book->id) }}">
                Sell Book
            </a>
        </div>


    </div>
@endsection
