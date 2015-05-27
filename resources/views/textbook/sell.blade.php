@extends('textbook')

@section('content')

    <head>
        <link href="{{ asset('/css/textbook-sell.css') }}" rel="stylesheet">
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src="{{asset('/js/textbook.js')}}" type="text/javascript"></script>
    </head>

    <div class="tab-filter-container">
        <ul class="tab-filters">
            <li class="filter">
                <a class="filter-link" href="{{ url('/textbook/buy') }}">Buy</a>
            </li>
            <li class="filter active">
                <a class="filter-link active" href="{{ url('/textbook/sell') }}">Sell</a>
            </li>
        </ul>
    </div>


    <div class="container">
        <div class="row">
            <form action="/textbook/sell/search" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group">
                    <label>Find the Textbook You'd Like to Trade In</label>
                    <input type="text" name="isbn" class="form-control" placeholder="Enter the textbook ISBN"/>
                </div>
                <input type="submit" name="search" class="btn btn-primary" value="Search"/>
            </form>
        </div>
    </div>
@endsection