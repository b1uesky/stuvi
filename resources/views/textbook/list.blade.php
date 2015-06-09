@extends('textbook')

@section('content')
    <div class="container">
        <div class="row">
            @foreach($books as $book)
                <div class="">
                    <div class="">
                        {{-- Link to each individual book --}}
                        <a href="{{ url('textbook/buy/textbook/'.$book->id) }}">
                            Title: {{ $book->title }}
                        </a>
                    </div>
                    <div class="">ISBN: {{ $book->isbn }}</div>
                </div>
                <hr>
            @endforeach
        </div>
    </div>
@endsection
