{{--Textbook sell page--}}

@extends('layouts.textbook')

@section('title', 'Sell Your Textbooks')
@section('description', 'Sell your textbooks to other students without leaving home.')

@section('css')
    {{-- Used for icons in sell page--}}
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="{{ asset('/css/textbook.css') }}">
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


        <!-- Search Bar Container-->
        <div class="container-fluid container-image">

            <div class="container">
            <div class="row">
                <h1 class="title">Sell Your Textbooks</h1>
                    <div class="searchbar default-searchbar">
                        <form action="/textbook/sell/search" method="post" id="form-isbn">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <label class="sr-only" for=""></label>
                            <div class="searchbar-input-container searchbar-input-container-query form-group" id="textbook-search">
                                <input type="text" name="isbn" class="form-control searchbar-input searchbar-input-query"
                                       id="sell-search-input"
                                       placeholder="Enter the textbook ISBN (10 or 13 digits)"/>
                            </div>
                            <div class="searchbar-input-container searchbar-input-container-submit form-group">
                                <input class="btn btn-primary btn-search" type="submit" value="Search">
                            </div>
                        </form>
                    </div>

                {{-- Search bar when xs screen --}}
                <div class="xs-guest-search-bar">
                    <form action="/textbook/sell/search" method="post" id="form-isbn">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="xs-guest-search-bar-input" id="xs-textbook-search">
                            <input type="text" name="isbn" class="form-control searchbar-input searchbar-input-query"
                                   id="sell-search-input"
                                   placeholder="Enter the textbook ISBN (10 or 13 digits)"/>
                        </div>
                        <div class="xs-guest-search-bar-input-submit">
                            <button class="btn btn-primary btn-lg btn-block" id="xs-sell-search-btn" type="submit"
                                    name="search" value="Search"> Search
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            </div>
        </div>


        <section class="textbook-intro">
            <div class="container">

                <div class="row">
                    <div class="col-sm-6">
                        {{--<div>Icon made by <a href="http://handdrawngoods.com" title="Hand Drawn Goods">Hand Drawn Goods</a> from <a href="http://www.flaticon.com" title="Flaticon">www.flaticon.com</a> is licensed under <a href="http://creativecommons.org/licenses/by/3.0/" title="Creative Commons BY 3.0">CC BY 3.0</a></div>--}}
                        <img class="img-responsive img-intro center-block" src="{{ asset('/img/icon/worldwide3.png') }}" alt="placeholder">
                    </div>
                    <div class="col-sm-6">
                        <h3>Sell to your classmates</h3>

                        <p>Sell to students near you with the same classes. We make the the entire process smooth and
                            easy, so you can spend less time selling and more time doing the things you enjoy.</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6 col-sm-push-6">
                        {{--<div>Icon made by <a href="http://handdrawngoods.com" title="Hand Drawn Goods">Hand Drawn Goods</a> from <a href="http://www.flaticon.com" title="Flaticon">www.flaticon.com</a> is licensed under <a href="http://creativecommons.org/licenses/by/3.0/" title="Creative Commons BY 3.0">CC BY 3.0</a></div>--}}
                        <img class="img-responsive img-intro center-block" src="{{ asset('/img/icon/dailycalendar20.png') }}" alt="placeholder">
                    </div>

                    <div class="col-sm-6 col-sm-pull-6">
                        <h3>Select your pickup time</h3>

                        <p>
                            You will be notified once your book has been sold. Then you can select a time
                            for us to come pickup your book. You will then be paid via Paypal once the book is delivered.
                        </p>
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-6">
                        {{--<div>Icon made by <a href="http://handdrawngoods.com" title="Hand Drawn Goods">Hand Drawn Goods</a> from <a href="http://www.flaticon.com" title="Flaticon">www.flaticon.com</a> is licensed under <a href="http://creativecommons.org/licenses/by/3.0/" title="Creative Commons BY 3.0">CC BY 3.0</a></div>--}}
                        <img class="img-responsive img-intro center-block" src="{{ asset('img/icon/currency36.png') }}" alt="">
                    </div>
                    <div class="col-sm-6">
                        <h3>Save Money!</h3>

                        <p>There's no need to pay for packaging supplies and shipping. We take care of the entire
                            process. With
                            <strong>NO</strong> fee, you can spend the extra dough on important things such as:
                            underage alcohol consumption,
                            laser hair removal, bail fees, life insurance scams, and more!
                        </p>
                    </div>
                </div>
            </div>
        </section>

@endsection

@section('javascript')
    @if(Auth::check())
        {{-- FormValidation --}}
        <script src="{{ asset('libs-paid/formvalidation-dist-v0.6.3/dist/js/formValidation.min.js') }}"></script>
        <script src="{{ asset('libs-paid/formvalidation-dist-v0.6.3/dist/js/framework/bootstrap.min.js') }}"></script>
    @endif

    <script src="{{ asset('/js/textbook/sell.js' )}}"></script>
@endsection
