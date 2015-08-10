{{--Textbook sell page--}}

@extends('app')

@section('title', 'Sell Textbooks')

@section('css')
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="{{ asset('/css/textbook.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('content')

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


    @include('includes.textbook.flash-message')

    <div class="container-main">
        <!-- Search Bar Container-->
        <div class="container-fluid search">
            <div class="row">
                <h1 id="title">Sell Textbooks</h1>
                <div class="searchbar default-searchbar">
                    <form action="/textbook/buy/search" method="get">

                        <div class="searchbar-input-container searchbar-input-container-query">
                            <input type="text" name="query" id="autocompleteBuy"
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
                        {{-- Show school selection if it's a guest --}}
                        @if(Auth::guest())
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
                <h2>Sell Books</h2>
                <!-- Divider -->
                <div class="container">
                    <hr id="hr1">
                </div>
                <!-- Row 1 -->
                <div class="row row-b" id="row1">
                    <!-- Row 1 Col 1 -->
                    <!-- xs: stack-->
                    <div class="container col-sm-4 col-xs-offset-0 col-sm-offset-0 col-md-offset-1" id="shrink-xs">
                        <i class="material-icons google-img">school</i>
                    </div>
                    <!-- Row 1 Col 2 -->
                    <div class="container col-xs-12 col-sm-6 col-xs-offset-0 col-sm-offset-1 col-md-offset-1 col-lg-offset-0"
                         id="shrink-xs">
                        <h3 id="h3-1">Sell to your classmates</h3>

                        <p>Sell to students near you with the same classes. We make the the entire process smooth and
                            easy, so you
                            can spend less time selling and more time doing the things you enjoy.</p>
                    </div>
                </div>
                <div class="row row-b" id="row2">
                    <!-- Row 2 Col 1 -->
                    <!-- xs: stack-->
                    <!-- col-xs-push/pull changes the ordering when it is not xs -->
                    <!-- need to fix xs -->
                    <div class="container col-xs-12 col-sm-3 col-xs-offset-0 col-sm-offset-0 col-md-offset-1 col-sm-push-7"
                         id="shrink-xs">
                        <img class="textbook-bottom-img" src="{{ asset('/img/textbook/clock.png') }}" alt="placeholder">
                    </div>
                    <!-- Row 2 Col 2 -->
                    <div class="container col-xs-12 col-sm-6 col-xs-offset-0 col-sm-offset-1 col-md-offset-1 col-lg-offset-1 col-sm-pull-4"
                         id="shrink-xs">
                        <h3 id="h3-2">Select your pickup time</h3>

                        <p>
                            You will be notified once your book has been sold. Then you can select a time
                            for us to come pickup your book. You will then be paid via Stripe in 2-5 days.
                        </p>
                    </div>
                </div>
                <div class="row row-b" id="row3">
                    <!-- Row 1 Col 1 -->
                    <!-- xs: stack-->
                    <div class="container col-sm-4 col-xs-offset-0 col-sm-offset-0 col-md-offset-1" id="shrink-xs">
                        <img class="textbook-bottom-img" src="{{ asset('/img/textbook/dollar.png') }}"
                             alt="placeholder">
                    </div>
                    <!-- Row 1 Col 2 -->
                    <div class="container col-xs-12 col-sm-6 col-xs-offset-0 col-sm-offset-1 col-md-offset-1 col-lg-offset-0"
                         id="shrink-xs">
                        <h3 id="h3-1">Save Money!</h3>

                        <p>There's no need to pay for packaging supplies and shipping. We take care of the entire
                            process. With
                            <strong>NO</strong> fee, you can spend the extra dough on important things such as:
                            underage alcohol consumption,
                            laser hair removal, bail fees, life insurance scams, and more!

                        </p>
                    </div>
                </div>
            </div>
            <!-- end container -->
        </div>  <!-- end container fluid -->



    </div>

@endsection

@section('javascript')
    @if(Auth::check())
        {{-- FormValidation --}}
        <script src="{{ asset('libs-paid/formvalidation-dist-v0.6.3/dist/js/formValidation.min.js') }}"></script>
        <script src="{{ asset('libs-paid/formvalidation-dist-v0.6.3/dist/js/framework/bootstrap.min.js') }}"></script>
    @endif

    <script src="{{ asset('/js/textbook/sell.js' )}}"></script>
@endsection
