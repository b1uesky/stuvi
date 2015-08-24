<!DOCTYPE html>
<html lang="en">
{{-- Page title --}}

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="@yield('description')">
    <meta name="author" content="Stuvi, Llc">
    <meta name="csrf_token" content="{{ csrf_token() }}">

    <link rel="icon" type="image/ico" href="{{ asset('img/favicon.ico') }}"/>
    <title>Stuvi - @yield('title')</title>

    <link rel="stylesheet" href="{{ asset('libs/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('libs-paid/formvalidation-dist-v0.6.3/dist/css/formValidation.min.css') }}">
    {{--<link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>--}}
    {{--<link href='http://fonts.googleapis.com/css?family=Signika:400' rel='stylesheet' type='text/css'>--}}
    <link rel="stylesheet" href="{{ asset('/css/app-home.css') }}"/>

    @yield('css')
</head>

<body>

<div class="container-wrapper">

    {{-- Session flash messages --}}
    @include('includes.alerts')

    {{-- Page content --}}
    @yield('content')

</div>

{{--loader shade--}}
{{--@include('includes.loader')--}}
@include('includes.textbook.footer')

@include('auth.login-signup-modal')

{{-- Page modals --}}
@yield('modals')

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

<script src="{{ asset('libs/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('libs/bootstrap/dist/js/bootstrap.min.js') }}"></script>
{{--<script src="{{ asset('js/loader.js') }}"></script>--}}


@if(Auth::guest())
    {{-- FormValidation --}}
    <script src="{{asset('libs-paid/formvalidation-dist-v0.6.3/dist/js/formValidation.min.js')}}"></script>
    <script src="{{asset('libs-paid/formvalidation-dist-v0.6.3/dist/js/framework/bootstrap.min.js')}}"></script>
    <script src="{{asset('js/auth/login.js')}}"></script>
@endif

<script src="{{ asset('js/alert.js') }}"></script>

@if(\App::environment('production'))
    <script src="{{ asset('js/googleanalytics.js') }}"></script>
@endif

@yield('javascript')
</body>

</html>
