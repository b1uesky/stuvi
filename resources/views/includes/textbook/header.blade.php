<!-- nav bar here -->

<header>
    <nav class="navbar navbar-default" id="nav" role="navigation">
        <div class="container-fluid">
            <div class="navbar-header">
                <!-- Toggle Nav into hamburger menu for small screens -->
                <button id="nav-toggle-collapse" type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle Navigation</span>
                    <i class="fa fa-bars"></i>
                </button>
                <div class="logo-container">
                    <a href="{{url('/home')}}"> <img src="{{asset('/img/logo-new-md.png')}}" class="img-responsive"> </a>
                </div>
            </div>
            <!-- End Navbar header -->

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <!-- Nav Bar Links-->
                <ul class="nav navbar-nav" id="nav-left">
                    <li><a href="{{ url('/textbook') }}" id="textbook-nav">Textbooks</a></li>
                    {{--<li><a href="{{ url('/coming') }}">Housing</a></li>--}}
                    {{--<li><a href="{{ url('/coming') }}">Club</a></li>--}}
                    {{--<li><a href="{{ url('/coming') }}">Group</a></li>--}}
                </ul>

                <!-- Navbar right -->
                <ul id="nav-right" class="nav navbar-nav navbar-right">
                    @yield('searchbar')

                    {{-- Not logged in --}}
                    @if (Auth::guest())
                        <li><a id="login-btn" class="nav-login" data-toggle="modal" href="#login-modal">
                                <i class="fa fa-sign-in"></i> Login</a></li>     <!-- added font awesome icons -->
                        <li><a id="register-btn" class="nav-login" data-toggle="modal" href="#signup-modal">
                                <i class="fa fa-user"></i> Sign Up</a></li>

                    {{-- Logged in --}}
                    @else
                        <!-- profile dropdown -->
                        <li class="dropdown" id="dp" style="z-index: 500;">
                            <a href="#" id="nav-drop" class="dropdown-toggle nav-dropdown" data-toggle="dropdown" role="button" aria-expanded="true">
                                <span nav-caret id="account-name">{{ Auth::user()->first_name }} </span><span
                                        class="caret nav-caret"></span>
                            </a>
                            <ul class="dropdown-menu" id="nav-dropdown" role="menu" aria-labelledby="nav-dropdown">
                                <li role="presentation">
                                    <a role="menuitem" tabindex="-1" href="{{ url('/user/overview') }}">Profile</a>
                                </li>
                                <li role="presentation">
                                    <a role="menuitem" tabindex="-1" href="{{ url('/user/account') }}">Your Account</a>
                                </li>
                                <li role="presentation">
                                    <a role="menuitem" tabindex="-1" href="{{ url('/order/buyer') }}">Your Orders</a>
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
                                <?php $cartQty = Auth::user()->cart->quantity ?>
                                {{-- If cart empty, open modal --}}
                                @if($cartQty == 0)
                                    <a href="#empty-cart-modal" data-toggle="modal" id="cart-link">Cart <i class="fa fa-shopping-cart" style="line-height: 19px;"></i></a>
                                @else
                                        <a href="{{ url('/cart') }}" id="cart-link">Cart ({{$cartQty}}) <i
                                                    class="fa fa-shopping-cart" style="line-height: 19px;"></i></a>
                                @endif
                        </li>
                    @endif
                </ul>
            </div>
            <!-- End collapse container -->
        </div>
        <!-- End navbar container -->
    </nav>
    <!-- login modal -->
    @include('auth.login-signup-modal')

    @if(Auth::check())
        <!-- Empty Cart Modal -->
        @if($cartQty == 0)
            @include('cart.empty-cart-modal')
        @endif
    @endif
</header>