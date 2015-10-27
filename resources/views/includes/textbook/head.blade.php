<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="@yield('description')">
    <meta name="author" content="Stuvi, Llc">
    <meta name="csrf_token" content="{{ csrf_token() }}">

    <title>Stuvi - @yield('title')</title>

    <link rel="icon" type="image/png" href="https://s3.amazonaws.com/stuvi-logo/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="https://s3.amazonaws.com/stuvi-logo/favicon-16x16.png" sizes="16x16" />

    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,600'>
    <link rel="stylesheet" href="{{ asset('build/css/textbook.css') }}">

    @yield('css')

</head>