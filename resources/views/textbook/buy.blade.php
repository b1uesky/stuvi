@extends('textbook')


@section('content')
    <head>
        <link href="{{ asset('/css/textbook-buy.css') }}" rel="stylesheet">
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src="{{asset('/js/textbook.js')}}" type="text/javascript"></script>
    </head>

    {{--textbook navigation bar--}}
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

    <div class="container-fluid search">
        <div class="row">
            <h1 id="buy-title">Buy or Rent Textbooks</h1>
            <form action="/textbook/sell/search" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group">
                    <div class="col-sm-8 col-sm-offset-2 search-row">
                        <input id="search-bar" type="text" name="isbn" class="form-control" placeholder="Enter the textbook ISBN"/>
                    </div>
                    <button class="btn btn-default search-btn" type="submit" name="search" >
                        <i class="fa fa-search search-icon"></i>
                    </button>
                </div>

                {{--<input type="submit" name="search" class="btn btn-primary" value="Search"/>--}}
            </form>

        </div>
    </div>

@endsection