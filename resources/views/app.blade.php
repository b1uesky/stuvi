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

@include('includes.head')

<body>
{{-- Nav bar --}}
@include('includes.header')

{{-- Page content --}}
@yield('content')

@include('includes.footer')

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

@yield('javascript')
</body>

</html>
