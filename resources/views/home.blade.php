<!-- Copyright Stuvi LLC 2015 -->

@extends('app-home')    {{--app.blade.php--}}

@section('description', "Student Village, college service provider")
@section('title', 'Boston Textbook Marketplace & More Coming Soon!')

@section('css')
    <link type="text/css" href="{{ asset('css/home.css') }}" rel="stylesheet">
    <link type="text/css" href="{{ asset('libs-paid/formvalidation-dist-v0.6.3/dist/css/formValidation.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('libs/jquery-ui/themes/smoothness/jquery-ui.min.css') }}">
@endsection

    @section('content')
    <!-- top half -->
    <div class="container-fluid" id="container-home-top">
        <div class="" id="navbar-container">
            @include('includes.textbook.header')
        </div>

        <div class="" id="head-tag-ghost-container">
            <h1 class="" id="head1">Welcome to Stuvi</h1>

            <p class="lead tagline">Because it takes a village to conquer college.</p>
            {{--@if (Auth::guest())--}}
                {{--<div class="ghost-btn-container">--}}
                    {{--<a class="btn ghost-btn" data-toggle="modal" href="#login-modal" role="button">Log In</a>--}}
                    {{--<a class="btn ghost-btn" data-toggle="modal" href="#signup-modal" role="button">Sign Up</a>--}}
                {{--</div>--}}
            {{--@endif--}}
        </div>
        {{-- Images currently 2000px x 1333px image quality 7/12 on Photoshop --}}
        <!-- Photos are owned by Nicholas Louie (owner), and are allowed for use on stuvi.com only. Attribution in the alt text
             must be provided. This must include the owner's name and link to the owner's Flickr.
             No one else but the owner may sell, copy, redistribute or edit his images.
             Visit Nick at flickr.com/photos/nickkeee
             -->
        <div id="slide-container">
            <div class="" id="slides">
                <img src="{{asset('img/nick/nlouie1.jpg')}}" alt="Charles River by Nick Louie - flickr.com/photos/nickkeee">
                <img src="{{asset('img/nick/nlouie2.jpg')}}" alt="EPC by Nick Louie - flickr.com/photos/nickkeee">
                <img src="{{asset('img/nick/nlouie8.jpg')}}" alt="NEU by Nick Louie - flickr.com/photos/nickkeee">
                <img src="{{asset('img/nick/nlouie3.jpg')}}" alt="Mass Art by Nick Louie - flickr.com/photos/nickkeee">
                <img src="{{asset('img/nick/nlouie4.jpg')}}" alt="Harvard by Nick Louie - flickr.com/photos/nickkeee">
                <img src="{{asset('img/nick/nlouie5.jpg')}}" alt="MIT by Nick Louie - flickr.com/photos/nickkeee">
            </div>
        </div>

        <div id="home-search-container">
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
                            <label class="sr-only" for="uni_id">University</label>
                            <select name="university_id"
                                    class="form-control searchbar-input searchbar-input-university"
                                    id="uni_id">
                                <option selected disabled>University</option>
                                @foreach($universities as $university)
                                    <option value="{{ $university->id }}">{{ $university->abbreviation }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    <div class="searchbar-input-container searchbar-input-container-submit default-guest-search-submit">
                        <button class="btn btn-default search-btn" type="submit" value="Search">
                            <i class="fa fa-search search-icon"></i>
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
                            <option selected disabled>University</option>
                            @foreach($universities as $university)
                                <option value="{{ $university->id }}">{{ $university->abbreviation }}</option>
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

    <!-- new bottom half -->
    <div class="container-fluid">
        <div class="container-fluid stuvi-container">
            <!-- row 1-->
            <div class="row">
                <div class="container container-description">
                    <h2>What is Stuvi?</h2>

                    <p>Stuvi is a marketplace built for college students, by college students. We're here to provide relevant services to help you succeed at school, and we're launching here in Boston, Massachusetts!</p>
                     <p><a class="btn primary-btn" href="{{url('/about/')}}">Learn More</a></p>
                </div>

                {{--<div class="container col-xs-offset-1 col-sm-7 col-sm-offset-3 col-md-offset-0 col-md-4"--}}
                     {{--id="img-info-1">--}}
                    {{--<img class="img-responsive" src="{{asset('/img/art-boston.jpg')}}" width="350px">--}}
                {{--</div>--}}
            </div>
        </div>
        {{--<div class="container-fluid home-textbook-container">--}}
            {{--<h1 id="home-textbook-title">Recommended Books</h1>--}}

            {{--<div class="row textbook-row">--}}
                {{--<div class="home-textbook col-sm-6 col-md-3">--}}
                    {{--<a href="#">--}}
                        {{--<img class="textbook-img" src="http://puu.sh/jhP6y/60bae9306c.png">--}}
                    {{--</a>--}}
                {{--</div>--}}
                {{--<div class="home-textbook col-sm-6 col-md-3">--}}
                    {{--<a href="#">--}}
                        {{--<img class="textbook-img" src="http://puu.sh/jhPi3/d63b4a67e5.png">--}}
                    {{--</a>--}}
                {{--</div>--}}
                {{--<div class="home-textbook col-sm-6 col-md-3">--}}
                    {{--<a href="#">--}}
                        {{--<img class="textbook-img" src="http://puu.sh/jhPpo/f6899af921.png">--}}
                    {{--</a>--}}
                {{--</div>--}}
                {{--<div class="home-textbook col-sm-6 col-md-3">--}}
                    {{--<a href="#">--}}
                        {{--<img class="textbook-img" src="http://puu.sh/jhPyr/dce3b699d1.png">--}}
                    {{--</a>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    </div> <!-- end bottom half -->

    {{--login-sign-up modal--}}
    @include('auth.login-signup-modal')

@endsection

@section('javascript')
    <script src="{{ asset('libs/slidejs3/source/jquery.slides.min.js' )}}"></script>
    <script src="{{asset('js/home.js')}}"></script>

    <script src="libs/jquery-ui/jquery-ui.min.js"></script>
    <script src="{{asset('js/autocomplete.js')}}"></script>
@endsection
