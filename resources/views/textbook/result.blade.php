@extends('textbook')

@section('content')
    <div class="container">
        <div class="row">
            <div>
                @if($image->large_image)
                    <img src="{{ $image->large_image }}" alt="" />
                @endif
                
                <p>ISBN:  {{ $book->isbn }}</p>
                <p>Title:  {{ $book->title }}</p>
                <p>edition {{ $book->edition }}th</p>
                <p>Author: {{ $book->author }}</p>
                <p>Number of Pages: {{ $book->num_pages }}</p>
            </div>

            <a href="{{ url('textbook/sell/product/create/'.$book->id) }}">
                Sell Book
            </a>
        </div>


    </div>
@endsection
