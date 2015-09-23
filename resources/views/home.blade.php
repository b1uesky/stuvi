<!-- Copyright Stuvi LLC 2015 -->

@extends('layouts.textbook')
@section('description', "Student Village, college service provider")
@section('title', 'Boston Textbook Marketplace & More Coming Soon!')

@section('textbook-header')
    {{-- Navigation Bar --}}
    <div id="navbar-transparent">
        <header>
            <nav class="navbar navbar-default" role="navigation">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <!-- Toggle Nav into hamburger menu for small screens -->
                        <button id="nav-toggle-collapse" type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                                data-target="#bs-example-navbar-collapse-1">
                            <span class="sr-only">Toggle Navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>

                        {{-- Logo only when nav bar collapses into hamburger menu --}}
                        <a id="xs-screen-logo-link" class="" href="{{url('/home')}}" >
                            <img id="xs-screen-logo-img" class="" src="{{asset('/img/logo/logo-md.png')}}" alt="stuvi logo">
                        </a>

                        <div class="logo-container">
                            {{-- If on homepage, show the home logo which has white text--}}
                            @if(Request::url() == url('/home') or Request::url() == url('/'))
                                <a href="{{url('/home')}}">
                                    <img src="{{asset('/img/logo/logo-text-white-md.png')}}" class="center-block" alt="stuvi logo">
                                </a>
                            @else
                                <a href="{{url('/home')}}">
                                    <img src="{{asset('/img/logo/logo-md.png')}}" class="center-block" alt="stuvi logo">
                                </a>
                            @endif

                        </div>
                    </div>
                    <!-- End Navbar header -->

                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <!-- Navbar left -->
                        <ul class="nav navbar-nav navbar-left">
                            <li>
                                <a class="nav-link dropdown-toggle disabled" href="{{ url('/textbook') }}" data-toggle="dropdown" data-hover="dropdown">Textbooks</a>
                                <ul class="dropdown-menu">
                                    <li><a tabindex="-1" href="{{ url('/textbook/buy') }}">Buy</a></li>
                                    <li><a tabindex="-1" href="{{ url('/textbook/sell') }}">Sell</a></li>
                                </ul>
                            </li>
                        </ul>

                        <!-- Navbar right -->
                        <ul class="nav navbar-nav navbar-right">
                            @yield('searchbar')

                            {{-- Not logged in --}}
                            @if (Auth::guest())
                                <li><a class="nav-link" data-toggle="modal" href="#login-modal">Login</a></li>
                                <li><a class="nav-link" data-toggle="modal" href="#signup-modal">Sign Up</a></li>
                                {{-- Logged in --}}
                                @else
                                        <!-- profile dropdown -->
                                <li class="dropdown" class="nav-link" style="z-index: 500;">
                                    <a href="#" class="dropdown-toggle nav-dropdown" data-toggle="dropdown" aria-expanded="true">
                                        <span>{{ Auth::user()->first_name }} </span>
                                        <span class="caret nav-caret"></span>
                                    </a>
                                    <ul class="dropdown-menu" role="menu" aria-labelledby="nav-dropdown">
                                        <li role="presentation">
                                            <a role="menuitem" tabindex="-1" href="{{ url('/order/buyer') }}">Your orders</a>
                                        </li>
                                        <li role="presentation">
                                            <a role="menuitem" tabindex="-1" href="{{ url('/order/seller') }}">Your sold books</a>
                                        </li>
                                        <li role="presentation">
                                            <a role="menuitem" tabindex="-1" href="{{ url('/user/bookshelf') }}">Your bookshelf</a>
                                        </li>
                                        <li role="separator" class="divider"></li>
                                        <li role="presentation">
                                            <a role="menuitem" tabindex="-1" href="{{ url('/user/account') }}">Settings</a>
                                        </li>
                                        <li role="presentation">
                                            <a role="menuitem" tabindex="-1" href="{{ url('/auth/logout') }}">Sign out</a>
                                        </li>
                                    </ul>
                                </li>
                                <!-- cart -->
                                <li class="cart">
                                    <?php $cartQty = Auth::user()->cart->quantity; ?>
                                    {{-- If cart empty, open modal --}}
                                    <label class="sr-only" for="nav-right-cart-link">Cart</label>
                                    <a href="{{ url('/cart') }}">
                                        <span class="glyphicon glyphicon-shopping-cart"></span>
                                        @if($cartQty == 0)
                                            <span class="cart-quantity hide">{{$cartQty}}</span>
                                        @else
                                            <span class="cart-quantity">{{$cartQty}}</span>
                                        @endif
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </div>
                    <!-- End collapse container -->
                </div>
                <!-- End navbar container -->
            </nav>
        </header>
    </div>
@overwrite

@section('content')

    <div class="container-fluid container-bg">

        <div class="container-top-half">

            <div class="va-container va-container-h va-container-v">
                <div class="va-middle text-center">
                    <h1 class="header-text">Welcome to Stuvi</h1>
                    <p class="lead tagline">Because it takes a village to conquer college.</p>
                </div>
            </div>

            <div class="container-search">
                <div class="searchbar default-searchbar">
                    <label class="sr-only" for="autocomplete">Textbook Search</label>

                    <form action="/textbook/buy/search" method="get">
                        <div class="searchbar-input-container searchbar-input-container-query">
                            <input type="text" name="query" id="autocomplete"
                                   class="form-control searchbar-input searchbar-input-query"
                                   placeholder="Enter the textbook ISBN, Title, or Author"/>
                        </div>

                        {{--Show school selection if it's a guest--}}
                        @if(Auth::guest())
                            <div class="searchbar-input-container searchbar-input-container-university">
                                <label class="sr-only" for="uni_id">University</label>
                                <select name="university_id" class="form-control searchbar-input searchbar-input-university"
                                        id="uni_id">
                                    @foreach(\App\University::where('is_public', true)->get() as $university)
                                        <option value="{{ $university->id }}">{{ $university->abbreviation }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif

                        <div class="searchbar-input-container searchbar-input-container-submit default-guest-search-submit">
                            <input class="btn btn-primary btn-search" type="submit" value="Search">
                        </div>
                    </form>
                </div>

                <div class="xs-guest-search-bar">
                    <form action="/textbook/buy/search" method="get">
                        <label class="sr-only" for="autocompleteBuy">Textbook Search</label>
                        <div class="xs-guest-search-bar-input">
                            <input type="text" name="query" id="autocompleteBuy"
                                   class="form-control searchbar-input"
                                   placeholder="Enter the textbook ISBN, Title, or Author"/>
                        </div>
                        {{--Show school selection if it's a guest--}}
                        @if(Auth::guest())
                            <div class="xs-guest-search-bar-input-uni">
                                <label class="sr-only">University ID</label>
                                <select name="university_id" class="form-control searchbar-input searchbar-input-university-with-border">
                                    @foreach(\App\University::where('is_public', true)->get() as $university)
                                        <option value="{{ $university->id }}">{{ $university->abbreviation }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                        <div class="xs-guest-search-bar-input-submit">
                            <button class="btn btn-primary btn-lg btn-block" type="submit" value="Search">
                                Search
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <section class="intro bg-white">
        <!-- Intro -->
        <div class="jumbotron">
            <div class="container text-center">
                <h1>What is Stuvi?</h1>
                <p>Stuvi is a marketplace built for college students, by college students. We're here to provide relevant services to help you succeed at school, and we're launching here in Boston, Massachusetts!</p>
                <p><a class="btn btn-primary btn-lg" href="{{ url('/about/') }}" role="button">Learn more</a></p>
            </div>
        </div>
    </section>

@endsection
