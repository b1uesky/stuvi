<!-- Prototype Homepage Copyright Stuvi 2015 -->

@extends('app-home')    <!-- app.blade.php -->

@section('title', 'Textbooks, Housing, Clubs, & More')

@section('css')
    <link type="text/css" href="{{ asset('css/home.css') }}" rel="stylesheet">
    <link type="text/css" href="{{ asset('formvalidation-dist-v0.6.3/dist/css/formValidation.min.css') }}"
          rel="stylesheet">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    @endsection

    @section('content')
            <!-- new top half -->
    <div class="container-fluid" id="container-home-top">
        <div class="" id="navbar-container">
            @include('includes.textbook.header')
        </div>

        <div class="" id="head-tag-ghost-container">
            <h1 id="head1">Welcome to Stuvi</h1>

            <p class="lead tagline">Because it takes a village to conquer college.</p>
            @if (Auth::guest())
                <div class="ghost-btn-container">
                    <a class="btn ghost-btn" data-toggle="modal" href="#login-modal" role="button">Log In</a>
                    <a class="btn ghost-btn" data-toggle="modal" href="#signup-modal" role="button">Sign Up</a>
                </div>
            @endif
        </div>
        {{-- Images currently 2000px x 1333px image quality 7/12 on PS --}}
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

        <!-- TODO: make this work properly..like a search for the entire stuvi site? idk -->
        <div id="home-search-container">
            <div class="searchbar">
                <form action="/textbook/buy/search" method="get">

                    <div class="searchbar-input-container searchbar-input-container-query">
                        <input type="text" name="query" id="autocompleteBuy"
                               class="form-control searchbar-input searchbar-input-query"
                               placeholder="Enter the textbook ISBN, Title, or Author"/>
                    </div>

                    {{-- Show school selection if it's a guest --}}
                    @if(Auth::guest())
                        <div class="searchbar-input-container searchbar-input-container-university">
                            <select name="university_id" class="form-control searchbar-input searchbar-input-university">
                                @foreach(\App\University::where('is_public', true)->get() as $university)
                                    <option value="{{ $university->id }}">{{ $university->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    <div class="searchbar-input-container searchbar-input-container-submit">
                        <button class="btn btn-default search-btn" type="submit" value="Search">
                            <i class="fa fa-search search-icon"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- new bottom half -->
    <div class="container-fluid" id="bottom-half">
        <div class="container-fluid stuvi-container">
            <!-- row 1-->
            <div class="row">
                <div class="container col-md-4 col-md-offset-2" id="info1">
                    <h1>What is Stuvi?</h1>

                    <p>
                        Stuvi is a marketplace built for college students, by college students. We're here to provide
                        relevant services to help you succeed at school, and we're launching here in Boston,
                        Massachusetts!
                        <a href="{{url('/about/')}}">Learn More.</a>
                    </p>
                </div>

                <div class="container col-xs-offset-1 col-sm-7 col-sm-offset-3 col-md-offset-0 col-md-4"
                     id="img-info-1">
                    <img class="img-responsive" src="{{asset('/img/art-boston.jpg')}}" width="350px">
                </div>
            </div>
            <!-- TODO: Add more content -->
        </div>
        <div class="container-fluid home-textbook-container">
            <h1 id="home-textbook-title">Recommended Books</h1>

            <div class="row textbook-row">
                <div class="home-textbook col-sm-6 col-md-3">
                    <a href="#">
                        <img class="textbook-img" src="{{ asset('/img/placeholder.png') }}">
                    </a>
                </div>
                <div class="home-textbook col-sm-6 col-md-3">
                    <a href="#">
                        <img class="textbook-img" src="{{ asset('/img/placeholder.png') }}">
                    </a>
                </div>
                <div class="home-textbook col-sm-6 col-md-3">
                    <a href="#">
                        <img class="textbook-img" src="{{ asset('/img/placeholder.png') }}">
                    </a>
                </div>
                <div class="home-textbook col-sm-6 col-md-3">
                    <a href="#">
                        <img class="textbook-img" src="{{ asset('/img/placeholder.png') }}">
                    </a>
                </div>
            </div>
        </div>
        <!-- services-->
        {{--<div class="container-fluid services">--}}
        {{--<div class="row">--}}
        {{--<h1>Our Services</h1>--}}
        {{--</div>--}}
        {{--<div class="row service-row">--}}
        {{--<div class="col-xs-12 col-sm-6 col-lg-3 service">--}}
        {{--<a href="{{ url('/textbook') }}"><i class="fa fa-book fa-5x"></i></a>--}}
        {{--<h4>Textbooks</h4>--}}

        {{--<p>Buy and sell textbooks at your campus</p>--}}
        {{--</div>--}}
        {{--<div class="col-xs-12 col-sm-6 col-lg-3 service">--}}
        {{--<a href="{{ url('/coming') }}"><i class="fa fa-home fa-5x"></i></a>--}}
        {{--<h4>Housing</h4>--}}

        {{--<p>Find off campus housing near your campus</p>--}}
        {{--</div>--}}
        {{--<div class="col-xs-12 col-sm-6 col-lg-3 service">--}}
        {{--<a href="{{ url('/coming') }}"><i class="fa fa-university fa-5x"></i></a>--}}
        {{--<h4>Clubs</h4>--}}

        {{--<p>Get involved with clubs and organizations</p>--}}
        {{--</div>--}}
        {{--<div class="col-xs-12 col-sm-6 col-lg-3 service">--}}
        {{--<a href="{{ url('/coming') }}"><i class="fa fa-users fa-5x"></i></a>--}}
        {{--<h4>Groups</h4>--}}

        {{--<p>Connect with students in your classes</p>--}}
        {{--</div>--}}
        {{--</div>--}}
        {{--</div> <!-- end services -->--}}

    </div> <!-- end bottom half -->

    <!-- login-sign-up modal -->
    @include('auth.login-signup-modal')

@endsection

@section('javascript')
    <script src="{{asset('js/slides/jquery.slides.min.js')}}"></script>
    <script src="{{asset('js/home.js')}}"></script>

    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
    <script src="{{asset('js/autocompleteBuy.js')}}"></script>
@endsection
