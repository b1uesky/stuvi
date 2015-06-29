{{--Textbook buy page--}}

@extends('textbook')

@section('content')
    <head>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="{{ asset('/css/textbook/textbook.css') }}" rel="stylesheet" type="text/css">
        <title> Stuvi - Buy Used Textbook</title>
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
            <li class="cart">
                <a href="{{ url('/cart') }}" class="cart-link"><i class="fa fa-shopping-cart fa-2x"></i></a>
            </li>
        </ul>
    </div>

    <!-- Search Bar Container-->
    <div class="container-fluid search">
        <div class="row">
            <h1 id="title">Buy Used Textbooks</h1>
            <form action="/textbook/buy/search" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group">
                    <div class="col-xs-8 col-xs-offset-2 search-row">
                        <input type="text" name="info" id="autocompleteBuy" class="form-control" placeholder="Enter the textbook ISBN, Title, or Author"/>
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
            <h2>Buy Used Books</h2>
            <!-- Divider -->
            <div class="container">
                <hr id = "hr1">
            </div>
            <!-- Row 1 -->
            <div class = "row row-b" id="row1">
                <!-- Row 1 Col 1 -->
                <!-- xs: stack-->
                <div class = "container col-sm-4 col-xs-offset-0 col-sm-offset-0 col-md-offset-1" id = "shrink-xs">
                    <img class="textbook-bottom-img" src="{{ asset('/img/search.png') }}" alt="placeholder">
                </div>
                <!-- Row 1 Col 2 -->
                <div class = "container col-xs-12 col-sm-6 col-xs-offset-0 col-sm-offset-1 col-md-offset-1 col-lg-offset-0"
                     id="shrink-xs">
                    <h3 id="h3-1">Find your books</h3>
                    <p>
                        Search the Stuvi database to find books from students near you. We are currently servicing Boston area
                        students. Search by book name, author or ISBN to continue!
                    </p>
                </div>
            </div>

            <div class = "row row-b" id="row2">
                <!-- Row 2 Col 1 -->
                <!-- xs: stack-->
                <!-- col-xs-push/pull changes the ordering when it is not xs -->
                <!-- need to fix xs -->
                <div class = "container col-xs-12 col-sm-3 col-xs-offset-0 col-sm-offset-0 col-md-offset-1 col-sm-push-7" id="shrink-xs">
                    <img id="truck-img" src="{{ asset('/img/truck.png') }}" alt="placeholder">
                </div>
                <!-- Row 2 Col 2 -->
                <div class = "container col-xs-12 col-sm-6 col-xs-offset-0 col-sm-offset-1 col-md-offset-1 col-lg-offset-1 col-sm-pull-4"
                     id="shrink-xs">
                    <h3 id="h3-2">Book delivery</h3>
                    <p>
                        We will deliver the book directly to you after you make a purchase. Our own team of couriers will
                        make sure your book is delivered quickly, and check that your book is in its advertised condition.
                    </p>
                </div>
            </div>
            <div class = "row row-b" id="row3">
                <!-- Row 3 Col 1 -->
                <!-- xs: stack-->
                <div class = "container col-sm-4 col-xs-offset-0 col-sm-offset-0 col-md-offset-1" id = "shrink-xs">
                    {{--<img src="http://placehold.it/250x250" alt = "placeholder">--}}
                    <i id="library-book-img" class="material-icons">library_books</i>
                </div>
                <!-- Row 3 Col 2 -->
                <div class = "container col-xs-12 col-sm-6 col-xs-offset-0 col-sm-offset-1 col-md-offset-1 col-lg-offset-0"
                     id="shrink-xs">
                    <h3 id="h3-3">Save money and study</h3>
                    <p>
                        Find the best prices for textbooks without leaving the comfort of your dorm.
                    </p>
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

@endsection

@section('javascript')
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
    <script src="{{asset('/js/jquery-ui.min.js')}}"></script>
    <script src="{{asset('/js/textbook.js')}}" type="text/javascript"></script>
    <script src="{{asset('/js/autocompleteBuy.js')}}" type="text/javascript"></script>
@endsection