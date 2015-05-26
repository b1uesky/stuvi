@extends('textbook')


@section('content')
    <head>
        <link href="{{ asset('/css/textbook-buy.css') }}" rel="stylesheet">
    </head>

    <div class="tab-filter-container">
        <ul class="tab-filters">
            <li class="filter">
                <a href="#0" data-type="color-1">Color 1</a>
            </li>
            <li class="filter">
                <a href="#0" data-type="color-2">Color 2</a>
            </li>
        </ul>
    </div>

    {{--<ul class="nav nav-tabs">--}}
    {{--<li class="active"><a href="{{ url('/textbook/buy') }}">Buy</a></li>--}}
    {{--<li><a href="{{ url('/textbook/sell') }}">Sell</a></li>--}}
    {{--</ul>--}}
@endsection