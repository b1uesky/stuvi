@extends('textbook')

@section('content')

    <head>
        <link href="{{ asset('/css/textbook-sell.css') }}" rel="stylesheet">
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src="{{asset('/js/textbook.js')}}" type="text/javascript"></script>
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
        </ul>
    </div>

    <!-- Add styling -->
    <!-- Search Bar Container-->
    <div class="container-fluid" id = "textbook-search">
        <div class = "container col-md-3"></div>                <!-- Buffer -->
        <div class = "container col-md-6" id = "search-container">
            <div class="row">
                <form action="/textbook/sell/search" method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <h1>Sell your used textbooks</h1>
                        <input type="text" name="isbn" class="form-control" placeholder="Enter the ISBN of your book"/>
                    </div>
                    <input type="submit" name="search" class="btn btn-primary" value="Search"/>
                </form>
            </div>
        </div>

    </div>

    <!-- Bottom half info -->
    <!-- Put important info about the features and details of our service -->
    <div class = "container-fluid" id = "textbook-bottom">

        <div class = "container">

            <h2> Sell Your Books</h2>
            <!-- Divider -->
            <div>
                <hr id = "hr1">
            </div>

            <!-- Row 1 -->
            <div class = "row" id="row1">
                <div class = "container col-md-2 col-sm-0" id = "buffer1-1"> </div>
                <div class = "container col-md-4 col-sm-12">        <!-- r1c1 for regular. stack for small-->
                    <img src="http://placehold.it/250x250">

                </div>

                <div class = "container col-md-5 col-sm-12">        <!-- r1c2 for regular. stack for small-->
                    <h3 id = "h3-1"> Header Example</h3>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla ultrices sodales urna, quis faucibus elit
                    tempor vitae. Suspendisse suscipit arcu at mattis volutpat. Proin eu ipsum ut sapien fermentum tristique.
                    Suspendisse ornare dui vel turpis finibus, quis lobortis eros varius.
                </div>
                <div class = "container col-md-1 col-sm-0" id = "buffer1-2"> </div>
            </div>

            <!-- Row 2 -->
            <div class = "row" id = "row2">

                <div class = "container col-md-5 col-sm-12">        <!-- r2c2 for regular. stack for small-->
                    <h3 id = "h3-1"> Header Example 2</h3>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla ultrices sodales urna, quis faucibus elit
                    tempor vitae. Suspendisse suscipit arcu at mattis volutpat. Proin eu ipsum ut sapien fermentum tristique.
                    Suspendisse ornare dui vel turpis finibus, quis lobortis eros varius.
                </div>

                <div class = "container col-md-2 col-sm-0" id = "buffer2-1"> </div>

                <div class = "container col-md-4 col-sm-12">        <!-- r2c1 for regular. stack for small-->
                    <img src="http://placehold.it/250x250">

                </div>

                <div class = "container col-md-1 col-sm-0" id = "buffer2-2"> </div>
            </div>
        </div>

        <!-- books.jpg licensing -->
        <p style="text-align: right;"><small>Books Photo by
                <a href="https://flic.kr/p/nfwhCe" target = "_blank"> Brittany Stevens </a>
                under <a href="https://creativecommons.org/licenses/by/2.0/" target = "_blank"> CC-BY-2.0</a> </small></p>


    </div>






@endsection