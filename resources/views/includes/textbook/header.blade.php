{{-- Navigation Bar --}}

{{-- Styling can be found in sass/sections/_navigation.sass--}}

{{-- Header.blade.php Variables--}}
<?php $url = Request::url() ?>

<header>
    <nav class="navbar navbar-default" role="navigation">
        <div class="container-fluid">
            <div class="navbar-header">
                <!-- Toggle Nav into hamburger menu for small screens -->
                <button id="nav-toggle-collapse" type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle Navigation</span>
                    <i class="fa fa-bars"></i>
                </button>

                {{-- Logo only when nav bar collapses into hamburger menu --}}
                <a id="xs-screen-logo-link" class="" href="{{url('/home')}}" >
                    <img id="xs-screen-logo-img" class="" src="{{asset('/img/logo-new-center.png')}}" alt="stuvi logo">
                </a>

                <div class="logo-container">
                    {{-- If on homepage, show the home logo which has white text--}}
                    @if($url == url('/home') or $url == url('/'))
                        <a href="{{url('/home')}}">
                            <img src="{{asset('/img/logo-home-md.png')}}" class="img-responsive" alt="stuvi logo">
                        </a>
                    @else
                        <a href="{{url('/home')}}">
                            <img src="{{asset('/img/logo-new-md.png')}}" class="img-responsive" alt="stuvi logo">
                        </a>
                    @endif

                </div>
            </div>
            <!-- End Navbar header -->

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <!-- Navbar left -->
                <ul class="nav navbar-nav navbar-left">
                    <li><a class="nav-link" href="{{ url('/textbook') }}">Textbooks</a></li>
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
                            <a href="#" class="dropdown-toggle nav-dropdown" data-toggle="dropdown" role="button" aria-expanded="true">
                                <span>{{ Auth::user()->first_name }} </span>
                                <span class="caret nav-caret"></span>
                            </a>
                            <ul class="dropdown-menu" role="menu" aria-labelledby="nav-dropdown">
                                <li role="presentation">
                                    <a role="menuitem" tabindex="-1" href="{{ url('/user/account') }}">Your Account</a>
                                </li>
                                <li role="presentation">
                                    <a role="menuitem" tabindex="-1" href="{{ url('/order/buyer') }}">Your Orders</a>
                                </li>
                                <li role="presentation">
                                    <a role="menuitem" tabindex="-1" href="{{ url('/user/bookshelf') }}">Your Bookshelf</a>
                                </li>
                                <li role="presentation">
                                    <a role="menuitem" tabindex="-1" href="{{ url('/order/seller') }}">Sold Books</a>
                                </li>
                                <li role="separator" class="divider"></li>
                                <li role="presentation">
                                    <a role="menuitem" tabindex="-1" href="{{ url('/auth/logout') }}">Logout</a>
                                </li>
                            </ul>
                        </li>
                        <!-- cart -->
                        <li class="cart">
                                <?php $cartQty = Auth::user()->cart->quantity; ?>
                                {{-- If cart empty, open modal --}}
                                <label class="sr-only" for="nav-right-cart-link">Cart</label>
                                <a href="{{ url('/cart') }}">
                                    <i class="fa fa-shopping-cart"></i>
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

