{{--
  -- app.blade for Stuvi.
  -- Contains the code for the navbar and footer
  -- May 2015
  -- Please read the doc for blade template: http://laravel.com/docs/5.1/blade
  --}}

<!DOCTYPE html>
<html lang="en">
{{-- Page title --}}
@section('title', 'Home')

@include('includes.textbook.head')

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

<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>

@if(!Auth::check())
  {{-- FormValidation --}}
  <script src="{{asset('formvalidation-dist-v0.6.3/dist/js/formValidation.min.js')}}"></script>
  <script src="{{asset('formvalidation-dist-v0.6.3/dist/js/framework/bootstrap.min.js')}}"></script>
  <script src="{{asset('js/auth.js')}}"></script>
@endif

@yield('javascript')
</body>

</html>
