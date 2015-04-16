@extends('textbook')

@section('content')
    <ul class="nav nav-tabs">
        <li><a href="{{ url('/textbook/buy') }}">Buy</a></li>
        <li class="active"><a href="{{ url('/textbook/sell') }}">Sell</a></li>
    </ul>

    <div class="container">
        <div class="row">
        </div>
    </div>
@endsection