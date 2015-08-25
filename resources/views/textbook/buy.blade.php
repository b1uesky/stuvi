{{--Textbook buy page--}}

@extends('layouts.textbook')

@section('title', 'Buy Textbooks')
@section('description', 'Buy textbooks from other students without leaving home.')

@section('css')
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="{{ asset('/css/textbook.css') }}">
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
        <div class="container-fluid container-image text-center">
            <div class="container">
            <div class="row">
                <h1 class="title">Buy Textbooks</h1>
                <div class="searchbar default-searchbar">
                    <form action="/textbook/buy/search" method="get">
                        <div class="searchbar-input-container searchbar-input-container-query">
                            <label class="sr-only" for="autocomplete">Search for Textbooks by ISBN, Title or Author</label>
                            <input type="text" name="query" id="autocomplete"
                                   class="form-control searchbar-input searchbar-input-query"
                                   placeholder="Enter the textbook ISBN, Title, or Author"/>
                        </div>

                        {{-- Show school selection if it's a guest --}}
                        @if(Auth::guest())
                            <div class="searchbar-input-container searchbar-input-container-university">
                                <label class="sr-only" for="uni-id">University ID</label>
                                <select name="university_id" class="form-control searchbar-input searchbar-input-university" id="uni_id">
                                    @foreach($universities as $university)
                                        <option value="{{ $university->id }}">{{ $university->abbreviation }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif

                        <div class="searchbar-input-container searchbar-input-container-submit default-guest-search-submit">
                            <input class="btn primary-btn search-btn" type="submit" value="Search">
                        </div>
                    </form>
                </div>

                <div class="xs-guest-search-bar">
                    <form action="/textbook/buy/search" method="get">
                        <div class="xs-guest-search-bar-input">
                            <label class="sr-only" for="autocompleteBuy">Search for Textbooks by ISBN, Title or Author</label>
                            <input type="text" name="query" id="autocompleteBuy"
                                   class="form-control searchbar-input searchbar-input-query"
                                   placeholder="Enter the textbook ISBN, Title, or Author"/>
                        </div>
                        @if(Auth::guest())
                            {{-- Show school selection if it's a guest --}}
                            <div class="xs-guest-search-bar-input-uni">
                                <label class="sr-only" for="uni-id-2">University ID</label>
                                <select name="university_id" class="form-control" id="uni-id-2">
                                    @foreach($universities as $university)
                                        <option value="{{ $university->id }}">{{ $university->abbreviation }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                        <div class="xs-guest-search-bar-input-submit">
                            <button class="btn primary-btn btn-lg btn-block" type="submit" value="Search">
                                Search
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            </div>
        </div>

        <!-- Textbook page bottom half -->
        <section class="textbook-intro">
            <div class="container">

                <div class="row">
                    <div class="col-sm-6">
                        {{--<div>Icon made by <a href="http://handdrawngoods.com" title="Hand Drawn Goods">Hand Drawn Goods</a> from <a href="http://www.flaticon.com" title="Flaticon">www.flaticon.com</a> is licensed under <a href="http://creativecommons.org/licenses/by/3.0/" title="Creative Commons BY 3.0">CC BY 3.0</a></div>--}}
                        <img class="img-responsive img-intro center-block" src="{{ asset('/img/icon/books104.png') }}" alt="placeholder">
                    </div>
                    <div class="col-sm-6">
                        <h3>Find your books</h3>
                        <p>
                            Search the Stuvi database to find books from students near you. Search by book name, author or ISBN to continue!
                        </p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6 col-sm-push-6">
                        {{--<div>Icon made by <a href="http://handdrawngoods.com" title="Hand Drawn Goods">Hand Drawn Goods</a> from <a href="http://www.flaticon.com" title="Flaticon">www.flaticon.com</a> is licensed under <a href="http://creativecommons.org/licenses/by/3.0/" title="Creative Commons BY 3.0">CC BY 3.0</a></div>--}}
                        <img class="img-responsive img-intro center-block" src="{{ asset('/img/icon/transport625.png') }}" alt="placeholder">
                    </div>

                    <div class="col-sm-6 col-sm-pull-6">
                        <h3>Book delivery</h3>

                        <p>
                            We will deliver the book directly to you after you make a purchase. Our own team of couriers
                            will make sure your book is delivered quickly, and check that your book is in its advertised
                            condition.
                        </p>
                    </div>

                </div>
                <div class="row">
                    <div class="col-sm-6">
                        {{--<div>Icon made by <a href="http://handdrawngoods.com" title="Hand Drawn Goods">Hand Drawn Goods</a> from <a href="http://www.flaticon.com" title="Flaticon">www.flaticon.com</a> is licensed under <a href="http://creativecommons.org/licenses/by/3.0/" title="Creative Commons BY 3.0">CC BY 3.0</a></div>--}}
                        <img class="img-responsive img-intro center-block" src="{{ asset('img/icon/currency36.png') }}" alt="">
                    </div>
                    <div class="col-sm-6">
                        <h3>Save money and study</h3>

                        <p>
                            Find the best prices for textbooks without leaving the comfort of your dorm.
                        </p>
                    </div>
                </div>
            </div>
        </section>

@endsection

@section('javascript')
    <script src="{{ asset('libs/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('/js/autocomplete.js') }}" type="text/javascript"></script>
@endsection