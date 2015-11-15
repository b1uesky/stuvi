@extends('layouts.textbook')
@section('description', "Student Village, college service provider")
@section('title', 'Boston Textbook Marketplace & More Coming Soon!')

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
                                        <a href="{{ url('cart') }}" class="btn btn-default navbar-btn">
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

    <div class="container-fluid container-bg">

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
                        <input type="text" name="query" id="autocomplete" class="form-control input-lg hidden-xs" placeholder="ISBN, title, or author"/>

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
                            <h2>What is Stuvi?</h2>
                            <p>Stuvi, or Student Village, is a marketplace built for college students, by college students.<br>
                                To help you succeed at school, we're launching our textbook trading service here in Boston!</p>
                            {{--<p><a class="btn btn-default btn-lg" href="{{ url('/about/') }}" role="button">Learn more</a></p>--}}
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- How it works --}}
        {{--<section id="how-it-works">--}}
        {{--<div class="jumbotron">--}}
        {{--<div class="container">--}}
        {{--<h2 class="text-center">How it works</h2>--}}
        {{--</div>--}}
        {{--</div>--}}
        {{--</section>--}}

        {{-- Features --}}
        <section id="features">
            <div class="jumbotron">
                <div class="container">
                    {{--<div>Icon made by <a href="http://handdrawngoods.com" title="Hand Drawn Goods">Hand Drawn Goods</a> from <a href="http://www.flaticon.com" title="Flaticon">www.flaticon.com</a> is licensed under <a href="http://creativecommons.org/licenses/by/3.0/" title="Creative Commons BY 3.0">CC BY 3.0</a></div>--}}

                    <div class="row">
                        <div class="col-md-4">
                            <img class="img-responsive center-block" src="https://s3.amazonaws.com/stuvi-icon/book_128.png" alt="placeholder">

                            <h3>Find your books</h3>
                            <p>
                                Get the best prices for textbooks from students near you, without leaving the comfort of your dorm.
                            </p>
                        </div>
                        <div class="col-md-4">
                            <img class="img-responsive center-block" src="https://s3.amazonaws.com/stuvi-icon/money_128.png" alt="">

                            <h3>Quick cash?</h3>
                            <p>
                                Besides selling your books to other students, simply trade in your books to us at a competitive price!
                            </p>
                        </div>
                        <div class="col-md-4">
                            <img class="img-responsive center-block" src="https://s3.amazonaws.com/stuvi-icon/paper-plane_128.png" alt="placeholder">

                            <h3>No packaging</h3>
                            <p>
                                Pack and ship your book to us?<br>
                                No, our own team of couriers will come and pickup your books.
                            </p>

                            {{--<h3>Book delivery</h3>--}}
                            {{--<p>--}}
                            {{--Our own team of couriers will make sure your book is delivered quickly, and check that your book is in its advertised--}}
                            {{--condition.--}}
                            {{--</p>--}}
                        </div>

                    </div>

                </div>
            </div>
        </section>
    </div>



@endsection
