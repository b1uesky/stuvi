@extends('layouts.textbook')

@section('title', 'Trade-In Program')

@section('textbook-header')
    <header>
        <nav class="navbar navbar-inverse" role="navigation">
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
                        <span class="logo-text-white">Stuvi</span>
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
                            <li class="dropdown" class="nav-link" id="profile-dropdown">
                                <a href="#" class="dropdown-toggle nav-dropdown" data-toggle="dropdown" aria-expanded="true">
                                    <span class="username">Hi {{ Auth::user()->first_name }}</span>
                                    <span class="account">Your account</span>
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
@overwrite

@section('content')

    <div id="trade-in-sections">
        <section id="trade-in-header">
            <div class="jumbotron">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12 text-center">
                            <h1>Textbook Trade-In Program</h1>

                            {{-- Searchbar --}}
                            <div class="trade-in-search-container center-block">
                                <form action="{{ url('textbook/search') }}" method="get">
                                    <div class="input-group">
                                        <input type="text" name="query" class="form-control input-lg" placeholder="Enter 10 or 13 digits ISBN..."/>

                                        <span class="input-group-btn">
                                            <button class="btn btn-warning btn-lg hidden-xs" type="submit">Sell Your Textbook Now</button>
                                            <button class="btn btn-warning btn-lg visible-xs-inline" type="submit">
                                                <span class="glyphicon glyphicon-search"></span>
                                            </button>
                                        </span>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="trade-in-step-1">
            <div class="jumbotron">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-6 col-sm-push-6">
                            <img class="center-block" src="https://s3.amazonaws.com/stuvi-graphics/checking-task-list-by-hand.png">
                        </div>

                        <div class="col-sm-6 col-sm-pull-6">
                            <h2>1. Post Your Book</h2>
                            <p>Simply upload your textbook and check<br>
                                <strong class="text-checkbox"><span class="glyphicon glyphicon-check"></span> I would like to join the Stuvi Book Trade-in Program</strong>.</p>
                            <small class="text-muted">* You can join the program on your textbook page as well.</small>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="trade-in-step-2">
            <div class="jumbotron">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-6">
                            <img class="center-block" src="https://s3.amazonaws.com/stuvi-graphics/people-in-meeting.png">
                        </div>

                        <div class="col-sm-6">
                            <h2>2. Wating For Approval</h2>
                            <p>Our team will review your book, offer a trade-in price and send you an email with details once we approved your book.</p>
                            <small class="text-muted">* This process may take at most 2 days.</small>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="trade-in-step-3">
            <div class="jumbotron">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-6 col-sm-push-6">
                            <img class="center-block" src="https://s3.amazonaws.com/stuvi-graphics/money-bg-exchange.png">
                        </div>

                        <div class="col-sm-6 col-sm-pull-6">
                            <h2>3. Schedule and Get Paid</h2>
                            <p>After you accept the offer and schedule a pickup, our courier will come to pickup your book.</p>
                            <small class="text-muted">* Get paid by cash or PayPal.</small>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    {{--<section id="trade-in-final">--}}
        {{--<div class="jumbotron">--}}
            {{--<div class="container">--}}
                {{--<div class="row">--}}
                    {{--<div class="text-center margin-30">--}}
                        {{--<a href="{{ url('/') }}" class="btn btn-lg btn-warning">Sell Your Textbook Now</a>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</section>--}}

@endsection