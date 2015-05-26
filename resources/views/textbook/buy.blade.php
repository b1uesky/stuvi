@extends('textbook')


@section('content')
    <head>
        <link href="{{ asset('/css/textbook-buy.css') }}" rel="stylesheet">
    </head>

    <div class="tab-filter-container">
        <ul class="tab-filters">
            <li class="filter active">
                <a class="filter-link active" href="{{ url('/textbook/buy') }}">Buy</a>
            </li>
            <li class="filter">
                <a class="filter-link" href="{{ url('/textbook/sell') }}">Sell</a>
            </li>
        </ul>
    </div>

    {{--<ul class="nav nav-tabs">--}}
    {{--<li class="active"><a href="{{ url('/textbook/buy') }}">Buy</a></li>--}}
    {{--<li><a href="{{ url('/textbook/sell') }}">Sell</a></li>--}}
    {{--</ul>--}}
@endsection