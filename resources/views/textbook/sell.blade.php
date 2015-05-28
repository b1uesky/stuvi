@extends('textbook')

@section('content')

    <head>
        <link href="{{ asset('/css/textbook-sell.css') }}" rel="stylesheet">
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src="{{asset('/js/textbook.js')}}" type="text/javascript"></script>
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
                        <h1>Find the Textbook You'd Like to Sell</h1>
                        <input type="text" name="isbn" class="form-control" placeholder="Enter the textbook ISBN"/>
                    </div>
                    <input type="submit" name="search" class="btn btn-primary" value="Search"/>
                </form>
            </div>
        </div>

    </div>

    <!-- Bottom half info -->
    <div class = "container-fluid" id = "textbook-bottom">

        <div class = "container">

            <h2> Sell Your Books</h2>
            <p> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla ultrices sodales urna, quis faucibus elit
                tempor vitae. Suspendisse suscipit arcu at mattis volutpat. Proin eu ipsum ut sapien fermentum tristique.
                Suspendisse ornare dui vel turpis finibus, quis lobortis eros varius. In gravida metus vitae magna tempus,
                scelerisque rhoncus mauris feugiat. Maecenas non maximus augue, sit amet dictum mauris. In tincidunt nibh
                ut ex semper, id fringilla ipsum consectetur. Ut nisi magna, efficitur sit amet aliquet sed, efficitur tempor
                turpis. Maecenas egestas nec leo sed tincidunt. Vivamus justo orci, viverra a lectus ut, mollis sollicitudin
                sem. Etiam consequat porta tortor ut vestibulum.
            </p>
        </div>




    </div>





@endsection