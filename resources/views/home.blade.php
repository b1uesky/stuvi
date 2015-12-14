@extends('layouts.textbook')
@section('title', 'Boston Textbook Marketplace')

@section('textbook-header')
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

                        <a href="{{ url('/') }}" class="navbar-brand navbar-brand-lg">
                            <img src="https://s3.amazonaws.com/stuvi-logo/stuvi-logo-sm.png" class="" alt="stuvi logo">
                            <span class="logo-text-white-home">Stuvi</span>
                        </a>

                    </div>
                    <!-- End Navbar header -->

                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

                        <!-- Navbar right -->
                        <ul class="nav navbar-nav navbar-right">

                            {{-- Not logged in --}}
                            @if (Auth::guest())
                                <li><a class="nav-link" data-toggle="modal" href="#login-modal">Login</a></li>
                                <li><a class="nav-link" data-toggle="modal" href="#signup-modal">Sign Up</a></li>
                                {{-- Logged in --}}
                                @else
                                        <!-- profile dropdown -->
                                <li class="dropdown" class="nav-link" style="z-index: 500;">
                                    <a href="#" class="dropdown-toggle nav-dropdown" data-toggle="dropdown" aria-expanded="true">
                                        <span>Hi {{ Auth::user()->first_name }}</span>
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
                                            <a role="menuitem" tabindex="-1" href="{{ url('/user/profile') }}">Settings</a>
                                        </li>
                                        <li role="presentation">
                                            <a role="menuitem" tabindex="-1" href="{{ url('/auth/logout') }}">Sign out</a>
                                        </li>
                                    </ul>
                                </li>
                                <!-- cart -->
                                <li id="cart">
                                    <?php $cartQty = Auth::user()->cart->quantity; ?>
                                    <div class="input-group">
                                        <a class="btn btn-default navbar-btn" data-toggle="modal" data-target="#cart-popup">
                                            <span class="glyphicon glyphicon-shopping-cart"></span>
                                            <span>Cart</span>

                                            @if($cartQty == 0)
                                                <span class="cart-quantity hide">{{$cartQty}}</span>
                                            @else
                                                <span class="cart-quantity">{{$cartQty}}</span>
                                            @endif
                                        </a>
                                    </div>
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

    <div class="container-fluid" id="home-bg">

        <div class="container-top-half">

            <div class="va-container va-container-h va-container-v">
                <div class="va-middle text-center">
                    <h1 class="header-text">Welcome to Stuvi</h1>
                    <p class="lead tagline">Find the right textbook for you.</p>
                </div>
            </div>


            {{-- Search bar --}}
            <div class="container-searchbar center-block">
                <form action="{{ url('textbook/search') }}" method="get" id="home-search">
                    <div class="input-group">
                        <input type="text" name="query" id="autocomplete" class="form-control input-lg" placeholder="ISBN, title, or author"/>

                        <span class="input-group-btn">
                            <button class="btn btn-primary btn-lg hidden-xs" type="submit">Search</button>
                            <button class="btn btn-primary btn-lg visible-xs-inline" type="submit">
                                <span class="glyphicon glyphicon-search"></span>
                            </button>
                        </span>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="sections">
        <!-- Intro -->
        <section id="intro">
            <div class="jumbotron">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12 text-center">
                            <h2><img src="https://s3.amazonaws.com/stuvi-icon/light+bulbs.png" alt=""> What is Stuvi?</h2>
                            <p>Stuvi, or Student Village, is a marketplace built for college students. To help you succeed at school, we're launching our textbook trading service here in Boston!</p>
                            {{--<p><a class="btn btn-default btn-lg" href="{{ url('/about/') }}" role="button">Learn more</a></p>--}}
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- How it works --}}
        <section id="how-it-works">
            <div class="jumbotron">
                <div class="container">
                    <h2 class="text-center">Sell your textbooks</h2>

                    <div class="row">
                        <div class="col-md-4">
                            <img class="img-responsive center-block" src="https://s3.amazonaws.com/stuvi-icon/listing8.png" alt="">
                            <h3>Post Your Book</h3>
                            <p>Describe book conditions and price your book.</p>
                        </div>

                        <div class="col-md-4">
                            <img class="img-responsive center-block" src="https://s3.amazonaws.com/stuvi-icon/envelope89.png" alt="">
                            <h3>Someone Bought Your Book</h3>
                            <p>Choose a pickup time at your convenience.</p>

                            <p><a href="{{ url('trade-in-program') }}" class="btn btn-primary btn-feature">Check Out Our Trade-In Program</a></p>
                        </div>

                        <div class="col-md-4">
                            <img class="img-responsive center-block" src="https://s3.amazonaws.com/stuvi-icon/transport796.png" alt="">
                            <h3>We Pickup Your Book</h3>
                            <p>Get paid by cash or PayPal.</p>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        {{-- Features --}}
        <section id="features">
            <div class="jumbotron">
                <div class="container">
                    {{--<div>Icon made by <a href="http://handdrawngoods.com" title="Hand Drawn Goods">Hand Drawn Goods</a> from <a href="http://www.flaticon.com" title="Flaticon">www.flaticon.com</a> is licensed under <a href="http://creativecommons.org/licenses/by/3.0/" title="Creative Commons BY 3.0">CC BY 3.0</a></div>--}}

                    <h2 class="text-center">We made it easy</h2>

                    <div class="row">
                        <div class="col-md-4">
                            <img class="img-responsive center-block" src="https://s3.amazonaws.com/stuvi-icon/open+book6.png" alt="placeholder">

                            <h3>Find Your Books</h3>
                            <p>
                                Get the best prices for textbooks from students near you, without leaving the comfort of your dorm.
                            </p>
                        </div>
                        <div class="col-md-4">
                            <img class="img-responsive center-block" src="https://s3.amazonaws.com/stuvi-icon/money405.png" alt="">

                            <h3>Quick Cash?</h3>
                            <p>
                                Besides selling your books to other students, simply trade in your textbooks at a competitive price!
                            </p>
                        </div>
                        <div class="col-md-4">
                            <img class="img-responsive center-block" src="https://s3.amazonaws.com/stuvi-icon/cardboard36.png" alt="placeholder">

                            <h3>No Packaging</h3>
                            <p>
                                Pack and ship your book to us? No, our own team of couriers will come and pickup your books.
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </div>



@endsection
