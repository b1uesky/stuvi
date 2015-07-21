<!-- nav bar here -->

<header>
    <nav class="navbar navbar-default" id="nav" role="navigation">
        <div class="container-fluid">
            <div class="navbar-header">
                <!-- Toggle Nav into hamburger menu for small screens -->
                <button id="nav-toggle-collapse" type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle Navigation</span>
                    <i class="fa fa-bars fa-lg"></i>
                </button>
                <div class="logo-container">
                    <a href="{{url('/home')}}"> <img src="{{asset('/img/logo-new-md.png')}}" class="img-responsive"> </a>
                </div>
            </div>
            <!-- End Navbar header -->

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <!-- Nav Bar Links-->
                <ul class="nav navbar-nav" id="nav-left">
                    <li><a href="{{ url('/textbook') }}" class="" id="textbook-nav">Textbook</a></li>
                    {{--<li><a href="{{ url('/coming') }}">Housing</a></li>--}}
                    {{--<li><a href="{{ url('/coming') }}">Club</a></li>--}}
                    {{--<li><a href="{{ url('/coming') }}">Group</a></li>--}}
                </ul>
                <!-- Navbar right -->
                <ul id="nav-right" class="nav navbar-nav navbar-right">
                    {{-- Not logged in --}}
                    @if (Auth::guest())
                        <li><a id="login-btn" class="nav-login" data-toggle="modal" href="#login-modal">
                                <i class="fa fa-sign-in"></i> Login</a></li>     <!-- added font awesome icons -->
                        <li><a id="register-btn" class="nav-login" data-toggle="modal" href="#signup-modal">
                                <i class="fa fa-user"></i> Sign Up</a></li>

                        <!-- sign up modal -->
                        <div class="login-signup-modal">
                            <div class="modal fade login-modal" id="login-modal" tabindex="-1" role="dialog"
                                 aria-labelledby="Login">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <!-- close button -->
                                            <button type="button" class="close close-modal-btn" data-dismiss="modal" aria-label="close"><span aria-hidden="true">&times;</span></button>
                                            <!-- header -->
                                            <h4><span class="glyphicon glyphicon-lock"></span> Login</h4>
                                        </div>
                                        <div class="modal-body">
                                            <form role="form"  action="{{ url('/auth/login') }}" method="post">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <!-- email -->
                                                <div class="form-group">
                                                    <label for="login-email"><span class="glyphicon glyphicon-user"></span> Email</label>
                                                    <input type="text" class="form-control" id="login-email" name="email" placeholder="Enter email" value="">
                                                </div>
                                                <!-- password -->
                                                <div class="form-group">
                                                    <label for="login-password"><span class="glyphicon glyphicon-eye-open"></span> Password</label>
                                                    <input type="password" class="form-control" name="password" id="login-password" placeholder="Enter password">
                                                </div>
                                                <!-- remember me -->
                                                <div class="checkbox" id="remember-me">
                                                    <label for="remember-me-box">
                                                        <input id="remember-me-box" type="checkbox" value="" checked>Remember me</label>
                                                </div>
                                                <button type="submit" class="btn primary-btn btn-block"><span class="glyphicon glyphicon-off"></span> Login</button>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <p>Not a member? <a data-toggle="modal" href="#signup-modal" data-dismiss="modal">Sign Up</a></p>
                                            <p>Forgot <a id="forgot-password" href="{{ url('/password/email') }}">Password?</a></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- sign up modal -->
                            <!-- TODO: MAKE THIS WORK !!! -->
                            <div class="modal fade signup-modal" id="signup-modal" tabindex="-1" role="dialog"
                                 aria-labelledby="SignUp">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <!-- close -->
                                            <button type="button" class="close close-modal-btn" data-dismiss="modal" aria-label="close"><span aria-hidden="true">&times;</span></button>
                                            <!-- header -->
                                            <h4><span class="glyphicon glyphicon-lock"></span> Sign Up</h4>
                                        </div>
                                        <div class="modal-body">
                                            <form role="form" method="POST" action="{{ url('/auth/register') }}">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <!-- first name -->
                                                <div class="form-group">
                                                    <label class="sr-only" for="register-first">First Name</label>
                                                    <input type="text" class="form-control" id="register-first" placeholder="First name">
                                                </div>
                                                <!-- last name -->
                                                <div class="form-group">
                                                    <label class="sr-only" for="register-last">Last Name</label>
                                                    <input type="text" class="form-control" id="register-last" placeholder="Last name">
                                                </div>
                                                <!-- email -->
                                                <div class="form-group">
                                                    <label class="sr-only" for="register-email">Email</label>
                                                    <input type="email" class="form-control" id="register-email" placeholder="Email">
                                                </div>
                                                <!-- password -->
                                                <div class="form-group">
                                                    <label class="sr-only" for="register-password">Password</label>
                                                    <input type="password" class="form-control" id="register-password" placeholder="Password">
                                                </div>
                                                <!-- phone number -->
                                                <div class="form-group">
                                                    <label class="sr-only" for="register-phone">Phone Number</label>
                                                    <input type="tel" class="form-control phone_number" name="phone_number" id="register-phone"
                                                           placeholder="Phone number" value="">
                                                </div>
                                                <!-- university -->
                                                <div class="form-group">
                                                    <select class="form-control" name="university_id">
                                                        <label class="sr-only" for="register-uni">School</label>
                                                        <option id="register-uni" selected disabled>University</option>
                                                       {{-- @foreach($universities as $university)
                                                            <option value="{{ $university->id }}">{{ $university->name }}</option>
                                                        @endforeach--}}
                                                    </select>
                                                </div>
                                                <button type="submit" class="btn primary-btn btn-block"><span class="glyphicon glyphicon-off"></span> Sign Up</button>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <p>Already a member? <a data-toggle="modal" href="#login-modal" data-dismiss="modal">Login</a></p>
                                            <p>Forgot <a id="forgot-password" href="{{ url('/password/email') }}">Password?</a></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    {{-- Logged in --}}
                    @else
                        <!-- profile dropdown -->
                        <li class="dropdown" id="dp">
                            <a href="#" id="nav-drop" class="dropdown-toggle nav-dropdown" data-toggle="dropdown" role="button"
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
                                <li role="separator" class="divider"></li>
                                <li role="presentation"><a role="menuitem" tabindex="-1"
                                                           href="{{ url('/auth/logout') }}">
                                        Logout</a></li>
                            </ul>
                        </li>
                        <!-- cart -->
                        <li class="cart">
                            <a href="{{ url('/cart') }}" id="cart-link">Cart <i class="fa fa-shopping-cart" style="line-height: 19px;"></i></a>
                        </li>
                    @endif

                </ul>
            </div>
            <!-- End collapse container -->
        </div>
        <!-- End navbar container -->
    </nav>
</header>