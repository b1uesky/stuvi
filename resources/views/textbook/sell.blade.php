@extends('textbook')

@section('content')

    <head>
        <link href="{{ asset('/css/textbook.css') }}" rel="stylesheet">

        <title> Stuvi - Sell Textbooks</title>
    </head>

    {{--textbook navigation bar--}}
    <div class="tab-filter-container">
        <ul class="tab-filters">
            <li class="filter">
                <a class="filter-link" href="{{ url('/textbook/buy') }}">Buy</a>
            </li>
            <li class="filter active">
                <a class="filter-link active" href="{{ url('/textbook/sell') }}">Sell</a>
            </li>
            <li class="cart">
                <a href="{{ url('/cart') }}" class="cart-link"><i class="fa fa-shopping-cart fa-2x"></i></a>
            </li>
        </ul>
    </div>

    {{-- Error message --}}
    @if (Session::has('message'))
        <div id = "message-cont">
            <div class="flash-message" id="message"> <i class="fa fa-exclamation-triangle"></i> {{ Session::get('message') }}</div>
        </div>
    @endif

    <!-- Search Bar Container-->
    <div class="container-fluid search">
        <div class="row">
            <h1 id="title">Sell Your Used Textbooks</h1>
            <form action="/textbook/sell/search" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group">
                    <div class="col-xs-8 col-xs-offset-2 search-row">
                        <input type="text" name="isbn" class="form-control" placeholder="Enter the textbook ISBN (10 or 13 digits)"/>
                    </div>
                    <button class="btn btn-default search-btn" type="submit" name="search" value="Search" >
                        <i class="fa fa-search search-icon"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>


    <!-- Textbook page bottom half -->
    <div class="container-fluid" id = "textbook-bottom">
        <div class = "container">
            <h2>Sell Books</h2>
            <!-- Divider -->
            <div class="container">
                <hr id = "hr1">
            </div>
            <!-- Row 1 -->
            <div class = "row row-b" id="row1">
                <!-- Row 1 Col 1 -->
                <!-- xs: stack-->
                <div class = "container col-sm-4 col-xs-offset-0 col-sm-offset-0 col-md-offset-1" id = "shrink-xs">
                    <img src="http://placehold.it/250x250" alt = "placeholder">
                </div>
                <!-- Row 1 Col 2 -->
                <div class = "container col-xs-12 col-sm-6 col-xs-offset-0 col-sm-offset-1 col-md-offset-1 col-lg-offset-0"
                     id="shrink-xs">
                    <h3 id = "h3-1">Sell to your classmates</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla ultrices sodales urna, quis faucibus elit
                        tempor vitae. Suspendisse suscipit arcu at mattis volutpat. Proin eu ipsum ut sapien fermentum tristique.
                        Suspendisse ornare dui vel turpis finibus, quis lobortis eros varius. </p>
                </div>
            </div>

            <div class = "row row-b" id="row2">
                <!-- Row 2 Col 1 -->
                <!-- xs: stack-->
                <!-- col-xs-push/pull changes the ordering when it is not xs -->
                <!-- need to fix xs -->
                <div class = "container col-xs-12 col-sm-3 col-xs-offset-0 col-sm-offset-0 col-md-offset-1 col-sm-push-7" id="shrink-xs">
                    <img src="http://placehold.it/250x250" alt = "placeholder">
                </div>
                <!-- Row 2 Col 2 -->
                <div class = "container col-xs-12 col-sm-6 col-xs-offset-0 col-sm-offset-1 col-md-offset-1 col-lg-offset-1 col-sm-pull-4"
                     id="shrink-xs">
                    <h3 id = "h3-2">Set your own price</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla ultrices sodales urna, quis faucibus elit
                        tempor vitae. Suspendisse suscipit arcu at mattis volutpat. Proin eu ipsum ut sapien fermentum tristique.
                        Suspendisse ornare dui vel turpis finibus, quis lobortis eros varius. </p>
                </div>
            </div>
        </div> <!-- end container -->

        <!-- books.jpg licensing -->
        <p style="text-align: right;"><small>Books Photo by
                <a href="https://flic.kr/p/nfwhCe" target = "_blank"> Brittany Stevens </a>
                under <a href="https://creativecommons.org/licenses/by/2.0/" target = "_blank"> CC-BY-2.0</a>
                Cropped and levels adjusted. </small>
        </p>
    </div>  <!-- end container fluid -->




    <!--- Scripts at bottom for faster page loading-->
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="{{asset('/js/textbook.js')}}" type="text/javascript"></script>


@endsection
