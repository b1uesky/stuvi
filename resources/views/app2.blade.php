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
    @yield('content')
</body>
</html>