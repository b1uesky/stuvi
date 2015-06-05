@extends('textbook')


@section('content')
    <div class="container">
        <div class="row">
            <div class="">
                ISBN: {{ $book->isbn }}
            </div>
            <div class="">
                Title: {{ $book->title }}
            </div>
            <div class="">
                Edition: {{ $book->edition }}
            </div>
            <div class="">
                Author: {{ $book->author }}
            </div>
        </div>
    </div>

@endsection
