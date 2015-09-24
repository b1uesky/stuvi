{{-- Navigation Bar --}}


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
                    <img id="xs-screen-logo-img" class="" src="https://s3.amazonaws.com/stuvi-logo/logo-md.png" alt="stuvi logo">
                </a>

                <div class="logo-container">
                    {{-- If on homepage, show the home logo which has white text--}}
                    <a href="{{url('/home')}}">
                        @if(Request::url() == url('/home') or Request::url() == url('/'))
                            <img src="https://s3.amazonaws.com/stuvi-logo/logo-text-white-md.png" class="center-block" alt="stuvi logo">
                        @else
                            <img src="https://s3.amazonaws.com/stuvi-logo/logo-md.png" class="center-block" alt="stuvi logo">
                        @endif
                    </a>

                </div>
            </div>
            <!-- End Navbar header -->

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <!-- Navbar left -->
                <ul class="nav navbar-nav navbar-left">
                    <li>
                        <a class="nav-link dropdown-toggle disabled" href="{{ url('/textbook') }}" data-toggle="dropdown" data-hover="dropdown" data-hover-delay="100">Textbooks</a>
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
