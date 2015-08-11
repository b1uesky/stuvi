{{--
  -- app.blade for Stuvi.
  -- Contains the code for the navbar and footer
  -- May 2015
  -- Please read the doc for blade template: http://laravel.com/docs/5.1/blade
  --}}

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="@yield('description')">
  <meta name="author" content="Stuvi, Llc">
  <meta name="csrf_token" content="{{ csrf_token() }}">

  <link rel="icon" type="image/ico" href="{{ asset('img/favicon.ico') }}"/>
  <title>Stuvi - @yield('title')</title>

  <link href="{{ asset('/css_app/app.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('/css/app-home.css') }}"/>
  <link rel="stylesheet" href="{{ asset('libs/font-awesome/css/font-awesome.min.css') }}">

  <!-- Fonts -->
  <link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>

  @yield('css')

  @include('includes.textbook.head')

</head>

<body>
{{-- Nav bar --}}
@include('includes.textbook.header')

{{-- Page content --}}
@yield('content')

@include('includes.textbook.footer')

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

<script src="{{ asset('libs/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('libs/bootstrap/dist/js/bootstrap.min.js') }}"></script>

@if(Auth::guest())
  {{-- FormValidation --}}
  <script src="{{asset('libs-paid/formvalidation-dist-v0.6.3/dist/js/formValidation.min.js')}}"></script>
  <script src="{{asset('libs-paid/formvalidation-dist-v0.6.3/dist/js/framework/bootstrap.min.js')}}"></script>
  <script src="{{asset('js/auth/login.js')}}"></script>
@endif

@if(\App::environment('production'))
  <script src="{{ asset('js/googleanalytics.js') }}"></script>
@endif

  @yield('javascript')
</body>

</html>
