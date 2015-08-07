{{--Textbook buy page--}}

@extends('app')

@section('title', 'Buy Textbooks')

@section('css')
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="{{ asset('/css/textbook.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ asset('libs/jquery-ui/themes/smoothness/jquery-ui.min.css') }}">
@endsection

@section('content')

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

    <!-- Search Bar Container-->
    <div class="container-fluid search">
        <div class="row">
            <h1 id="title">Buy Textbooks</h1>
            <div class="searchbar default-searchbar">
                <form action="/textbook/buy/search" method="get">

                    <div class="searchbar-input-container searchbar-input-container-query">
                        <input type="text" name="query" id="autocomplete"
                               class="form-control searchbar-input searchbar-input-query"
                               placeholder="Enter the textbook ISBN, Title, or Author"/>
                    </div>
                    {{-- Show school selection if it's a guest --}}
                    @if(Auth::guest())
                        <div class="searchbar-input-container searchbar-input-container-university">
                            <select name="university_id"
                                    class="form-control searchbar-input searchbar-input-university">
                                @foreach(\App\University::where('is_public', true)->get() as $university)
                                    <option value="{{ $university->id }}">{{ $university->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    <div class="searchbar-input-container searchbar-input-container-submit">
                        <button class="btn primary-btn search-btn" type="submit" value="Search">
                            <i class="fa fa-search fa-lg search-icon"></i>
                        </button>
                    </div>
                </form>
            </div>

            <div class="xs-guest-search-bar">
                <form action="/textbook/buy/search" method="get">
                    <div class="xs-guest-search-bar-input">
                        <input type="text" name="query" id="autocompleteBuy"
                               class="form-control searchbar-input searchbar-input-query"
                               placeholder="Enter the textbook ISBN, Title, or Author"/>
                    </div>
                    @if(Auth::guest())
                        {{-- Show school selection if it's a guest --}}
                        <div class="xs-guest-search-bar-input-uni">
                            <select name="university_id"
                                    class="form-control">
                                @foreach(\App\University::where('is_public', true)->get() as $university)
                                    <option value="{{ $university->id }}">{{ $university->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                    <div class="xs-guest-search-bar-input-submit">
                        <button class="btn primary-btn" type="submit" value="Search" style="width:100%;">
                            Search
                        </button>
                    </div>
                </form>
            </div>


        </div>
    </div>

    <!-- Textbook page bottom half -->
    <div class="container-fluid" id="textbook-bottom">
        <div class="container">
            <h2>Buy Used Books</h2>
            <!-- Divider -->
            <div class="container">
                <hr id="hr1">
            </div>
            <!-- Row 1 -->
            <div class="row row-b" id="row1">
                <!-- Row 1 Col 1 -->
                <!-- xs: stack-->
                <div class="container col-sm-4 col-xs-offset-0 col-sm-offset-0 col-md-offset-1" id="shrink-xs">
                    <img class="textbook-bottom-img img-responsive" src="{{ asset('/img/textbook/search.png') }}" alt="placeholder">
                </div>
                <!-- Row 1 Col 2 -->
                <div class="container col-xs-12 col-sm-6 col-xs-offset-0 col-sm-offset-1 col-md-offset-1 col-lg-offset-0"
                     id="shrink-xs">
                    <h3 id="h3-1">Find your books</h3>

                    <p>
                        Search the Stuvi database to find books from students near you. We are currently servicing
                        Boston area
                        students. Search by book name, author or ISBN to continue!
                    </p>
                </div>
            </div>

            <div class="row row-b" id="row2">
                <!-- Row 2 Col 1 -->
                <!-- xs: stack-->
                <!-- col-xs-push/pull changes the ordering when it is not xs -->
                <!-- need to fix xs -->
                <div class="container col-xs-12 col-sm-3 col-xs-offset-0 col-sm-offset-0 col-md-offset-1 col-sm-push-7"
                     id="shrink-xs">
                    <img id="truck-img" src="{{ asset('/img/textbook/truck.png') }}" alt="placeholder">
                </div>
                <!-- Row 2 Col 2 -->
                <div class="container col-xs-12 col-sm-6 col-xs-offset-0 col-sm-offset-1 col-md-offset-1 col-lg-offset-1 col-sm-pull-4"
                     id="shrink-xs">
                    <h3 id="h3-2">Book delivery</h3>

                    <p>
                        We will deliver the book directly to you after you make a purchase. Our own team of couriers
                        will
                        make sure your book is delivered quickly, and check that your book is in its advertised
                        condition.
                    </p>
                </div>
            </div>
            <div class="row row-b" id="row3">
                <!-- Row 3 Col 1 -->
                <!-- xs: stack-->
                <div class="container col-sm-4 col-xs-offset-0 col-sm-offset-0 col-md-offset-1" id="shrink-xs">
                    <i class="material-icons google-img">library_books</i>
                </div>
                <!-- Row 3 Col 2 -->
                <div class="container col-xs-12 col-sm-6 col-xs-offset-0 col-sm-offset-1 col-md-offset-1 col-lg-offset-0"
                     id="shrink-xs">
                    <h3 id="h3-3">Save money and study</h3>

                    <p>
                        Find the best prices for textbooks without leaving the comfort of your dorm.
                    </p>
                </div>
            </div>
        </div>
        <!-- end container -->
    </div>  <!-- end container fluid -->

@endsection

@section('javascript')
    <script src="{{ asset('libs/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('/js/autocomplete.js') }}" type="text/javascript"></script>
@endsection