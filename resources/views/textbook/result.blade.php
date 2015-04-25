@extends('textbook')

@section('content')
    <ul class="nav nav-tabs">
        <li><a href="{{ url('/textbook/buy') }}">Buy</a></li>
        <li class="active"><a href="{{ url('/textbook/sell') }}">Sell</a></li>
    </ul>

    @foreach($books as $book)
        <div>{{ $book->title }}</div>
    @endforeach
@endsection