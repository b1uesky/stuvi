{{--
  -- app.blade for Stuvi.
  -- Contains the code for the navbar and footer
  -- May 2015
  --}}


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{--<title>Laravel</title>--}}

    <link href="{{ asset('/css/app.css') }}"                rel="stylesheet">
    <link href="{{ asset('/css/navigation.css') }}"         rel="stylesheet">
    {{--<link href="{{ asset('/css/footer.css') }}"         rel="stylesheet">--}}
    <link href="{{ asset('css/footer-distributed.css') }}"  rel="stylesheet">   <!-- Footer required -->
    <link href="{{ asset('css/font-awesome.min.css') }}"    rel="stylesheet">   <!-- Footer & Nav required -->
    <link href="{{ asset('css/font-awesome.css') }}"        rel="stylesheet">   <!-- Footer & Nav required -->

    <!-- Fonts -->
    <link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>


</head>
<body>

<!-- NAV BAR -->
<nav class="navbar navbar-default" id="nav" role ="navigation">
    <div class="container-fluid">               <!-- Expand to full width -->
        <div class="navbar-header">
            <!-- Toggle Nav into hamburger menu for small screens -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle Navigation</span>
                <i class="fa fa-bars fa-lg"></i>
                {{--<span class="icon-bar"></span>--}}
                {{--<span class="icon-bar"></span>--}}
                {{--<span class="icon-bar"></span>--}}
            </button>
            <div class="logo-container">
                <a href="{{url('/home')}}">   <img src="{{asset('/img/stuvi-logo.png')}}" class="img-responsive">  </a>
            </div>
        </div>  <!-- End Navbar header -->

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <!-- Nav Bar Links-->
            <ul class="nav navbar-nav">
                <li><a href="{{ url('/textbook') }}" class="" id="textbook-nav">Textbooks</a></li>
                <li><a href="{{ url('/housing') }}">Housing</a></li>
                <li><a href="{{ url('/club') }}">Clubs</a></li>
                <li><a href="{{ url('/group') }}">Groups</a></li>
            </ul>
            <!-- Navbar right -->
            <ul class="nav navbar-nav navbar-right">
                @if (Auth::guest())
                    <li><a class="nav-login" href="{{ url('/login') }}">
                            <i class="fa fa-sign-in"></i> Login</a></li>     <!-- added font awesome icons -->
                    <li><a class="nav-login" href="{{ url('/register') }}">
                            <i class="fa fa-user"></i> Register</a></li>
                @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle nav-dropdown" data-toggle="dropdown" role="button"
                           aria-expanded="true"><span nav-caret id = "account-name">{{ Auth::user()->first_name }}</span><span class="caret nav-caret"></span></a>
                        <ul class="dropdown-menu" role="menu" aria-labelledby="nav-dropdown">
                            <li role="presentation"><a role="menuitem" tabindex="-1" href="{{ url('/user/profile') }}">
                                    Profile</a></li>
                            <li role="presentation"><a role="menuitem" tabindex="-1" href="{{ url('/user/account') }}">
                                    Your Account</a></li>
                            <li role="presentation"><a role="menuitem" tabindex="-1" href="{{ url('/order/buyer') }}">
                                    Your Orders</a></li>
                            <li role="presentation"><a role="menuitem" tabindex="-1" href="{{ url('/order/seller') }}">
                                    Sold Books</a></li>
                            <li role="presentation"><a role="menuitem" tabindex="-1" href="{{ url('/cart') }}">
                                    Shopping Cart</a></li>
                            <li role="presentation"><a role="menuitem" tabindex="-1" href="{{ url('/auth/logout') }}">
                                    Logout</a></li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>  <!-- End collapse container -->
    </div>  <!-- End navbar container -->
</nav>

<!-- End Nav Bar -->



<!-- Displays page content -->
@yield('content')

<!-- FOOTER. See footer styling at footer-distribyted.css -->
<footer class="footer-distributed">
    <!-- Social Media -->
    <div class="footer-right">
        <!-- Uses font-awesome.css -->
        <a class="social" href="https://www.facebook.com/StuviBoston" target="_blank"><i class="fa fa-facebook"></i></a>
        <a class="social" href="https://twitter.com/StuviBoston" target="_blank"><i class="fa fa-twitter"></i></a>
        <a class="social" href="https://www.linkedin.com/company/stuvi?trk=biz-companies-cym" target="_blank"><i class="fa fa-linkedin"></i></a>
        {{--<a class="social" href="#"><i class="fa fa-github"></i></a>--}}

    </div>

    <div class="footer-left">

        <p class="footer-links">
            <a class="footer-link" href="{{url('/home')}}">Home</a>
            ·
            <a class="footer-link"  href="{{url('/textbook')}}">Textbooks</a>
            ·
            <a class="footer-link"  href="{{url('/housing')}}">Housing</a>
            ·
            <a class="footer-link"  href="{{url('/club')}}">Clubs</a>
            ·
            <a class="footer-link"  href="{{url('/group')}}">Groups</a>
            ·
            <a class="footer-link"  href="{{ url('/about') }}">About</a>
            ·
            <a class="footer-link"  href="{{ url('/contact') }}">Contact</a>
        </p>
        <hr>
        <p>&copy; Stuvi, LLC. 2015</p>
    </div>

</footer>
<!-- END FOOTER -->



</body>

<!--- Scripts at bottom for faster page loading-->

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
<script src="{{asset('/js/navigation.js')}}" type="text/javascript"></script>


</html>
