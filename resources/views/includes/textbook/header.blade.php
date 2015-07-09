<!-- nav bar here -->

<header>
    <nav class="navbar navbar-default" id="nav" role="navigation">
        <div class="container-fluid">               <!-- Expand to full width -->
            <div class="navbar-header">
                <!-- Toggle Nav into hamburger menu for small screens -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle Navigation</span>
                    <i class="fa fa-bars fa-lg"></i>
                    {{--<span class="icon-bar"></span>--}}
                    {{--<span class="icon-bar"></span>--}}
                    {{--<span class="icon-bar"></span>--}}
                </button>
                <div class="logo-container">
                    <a href="{{url('/home')}}"> <img src="{{asset('/img/stuvi-logo.png')}}" class="img-responsive"> </a>
                </div>
            </div>
            <!-- End Navbar header -->

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <!-- Nav Bar Links-->
                <ul class="nav navbar-nav">
                    <li><a href="{{ url('/textbook') }}" class="" id="textbook-nav">Textbooks</a></li>
                    <li><a href="{{ url('/coming') }}">Housing</a></li>
                    <li><a href="{{ url('/coming') }}">Clubs</a></li>
                    <li><a href="{{ url('/coming') }}">Groups</a></li>
                </ul>
                <!-- Navbar right -->
                <ul class="nav navbar-nav navbar-right">
                    @if (Auth::guest())
                        <li><a class="nav-login" href="{{ url('/login') }}">
                                <i class="fa fa-sign-in"></i> Login</a></li>     <!-- added font awesome icons -->
                        <li><a class="nav-login" href="{{ url('/register') }}">
                                <i class="fa fa-user"></i> Sign Up</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle nav-dropdown" data-toggle="dropdown" role="button"
                               aria-expanded="true"><span nav-caret
                                                          id="account-name">{{ Auth::user()->first_name }} </span><span
                                        class="caret nav-caret"></span></a>
                            <ul class="dropdown-menu" role="menu" aria-labelledby="nav-dropdown">
                                <li role="presentation"><a role="menuitem" tabindex="-1"
                                                           href="{{ url('/user/profile') }}">
                                        Profile</a></li>
                                <li role="presentation"><a role="menuitem" tabindex="-1"
                                                           href="{{ url('/user/account') }}">
                                        Your Account</a></li>
                                <li role="presentation"><a role="menuitem" tabindex="-1"
                                                           href="{{ url('/order/buyer') }}">
                                        Your Orders</a></li>
                                <li role="presentation"><a role="menuitem" tabindex="-1"
                                                           href="{{ url('/order/seller') }}">
                                        Sold Books</a></li>
                           {{--     <li role="presentation"><a role="menuitem" tabindex="-1" href="{{ url('/cart') }}">
                                        Shopping Cart</a></li>--}}
                                <li role="presentation"><a role="menuitem" tabindex="-1"
                                                           href="{{ url('/auth/logout') }}">
                                        Logout</a></li>
                            </ul>
                        </li>
                        <li class="cart">
                            <a href="{{ url('/cart') }}" class="cart-link"><i class="fa fa-shopping-cart fa-2x"></i></a>
                        </li>
                    @endif

                </ul>
            </div>
            <!-- End collapse container -->
        </div>
        <!-- End navbar container -->
    </nav>
</header>