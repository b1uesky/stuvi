<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Laravel</title>

	<link href="{{ asset('/css/app.css') }}"                rel="stylesheet">
    <link href="{{ asset('/css/navigation.css') }}"         rel="stylesheet">
    <link href="{{ asset('/css/footer.css') }}"             rel="stylesheet">
    <link href="{{ asset('css/footer-distributed.css') }}"  rel="stylesheet">
    <link href="{{ asset('css/font-awesome.min.css') }}"    rel="stylesheet">   <!-- Footer required -->
    <link href="{{ asset('css/font-awesome.css') }}"        rel="stylesheet">   <!-- Footer required -->

	<!-- Fonts -->
	<link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
    <script src="{{asset('/js/navigation.js')}}" type="text/javascript"></script>
</head>
<body>
	<nav class="navbar navbar-default" id="nav">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle Navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
                <div class="logo-container">
                    <a href="{{url('/home')}}">   <img src="{{asset('/img/stuvi-logo.png')}}" class="img-responsive">  </a>
                </div>
			</div>

			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
                    <li><a href="{{ url('/textbook') }}" class="" id="textbook-nav">Textbooks</a></li>
                    <li><a href="{{ url('/housing') }}">Housing</a></li>
                    <li><a href="{{ url('/club') }}">Clubs</a></li>
                    <li><a href="{{ url('/group') }}">Groups</a></li>
				</ul>

				<ul class="nav navbar-nav navbar-right">
					@if (Auth::guest())
						<li><a href="{{ url('/login') }}" id="login-nav">Login</a></li>
						<li><a href="{{ url('/register') }}">Register</a></li>
					@else
						<li class="dropdown">
							<a href="#" class="dropdown-toggle nav-dropdown" data-toggle="dropdown" role="button" aria-expanded="true">{{ Auth::user()->name }} <span class="caret nav-caret"></span></a>
							<ul class="dropdown-menu" role="menu" aria-labelledby="nav-dropdown">
								<li role="presentation"><a role="menuitem" tabindex="-1" href="{{ url('/auth/logout') }}">Logout</a></li>
							</ul>
						</li>
					@endif
				</ul>
			</div>
		</div>
	</nav>
    @yield('content')

    <footer class="footer-distributed">

        <!-- Fix alignment!!!! -->
        <div class="footer-right">

            <a href="#"><i class="fa fa-facebook"></i></a>
            <a href="#"><i class="fa fa-twitter"></i></a>
            <a href="#"><i class="fa fa-linkedin"></i></a>
            <a href="#"><i class="fa fa-github"></i></a>

        </div>

        <div class="footer-left">

            <p class="footer-links">
                <a href="{{url('/home')}}">Home</a>
                ·
                <a href="{{url('/textbook')}}">Textbooks</a>
                ·
                <a href="{{url('/housing')}}">Housing</a>
                ·
                <a href="{{url('/club')}}">Clubs</a>
                ·
                <a href="{{url('/group')}}">Groups</a>
                ·
                <a href="{{ url('/') }}">About</a>
                ·
                <a href="{{ url('/') }}">Contact</a>
            </p>

            <p>Stuvi &copy; 2015</p>
        </div>

    </footer>


</body>
</html>
