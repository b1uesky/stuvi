<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Student Village, college service provider">
    <meta name="author" content="Stuvi">
    <meta name="csrf_token" content="{{ csrf_token() }}">

    <title>Stuvi - @yield('title')</title>

    <link href="{{ asset('/css_app/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/css/main.css') }}"/>
    <link rel="stylesheet" href="{{ asset('libs/font-awesome/css/font-awesome.min.css') }}">

    <!-- Fonts -->
    <link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>

    @yield('css')
</head>