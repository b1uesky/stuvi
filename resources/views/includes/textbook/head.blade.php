<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="@yield('description')">
    <meta name="author" content="Stuvi, Llc">
    <meta name="csrf_token" content="{{ csrf_token() }}">

    <title>Stuvi - @yield('title')</title>

    <link rel="icon" type="image/ico" href="{{ asset('img/favicon.ico') }}"/>
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,600'>
    <link rel="stylesheet" href="{{ asset('libs/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/jquery-ui/themes/smoothness/jquery-ui.min.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/bootstrap-select/dist/css/bootstrap-select.min.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/sortable/css/sortable-theme-minimal.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/main.css') }}">

    @yield('css')

</head>