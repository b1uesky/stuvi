@extends('textbook')

@section('content')
    <ul class="nav nav-tabs">
        <li class="active"><a href="{{ url('/textbook/buy') }}">Buy</a></li>
        <li><a href="{{ url('/textbook/sell') }}">Sell</a></li>
    </ul>
@endsection