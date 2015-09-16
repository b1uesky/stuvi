<!DOCTYPE html>
<html>

@section('title', 'Home')

@include('includes.express.head')

<body>

@include('includes.express.header')

@yield('content')

<script src="{{ asset('libs/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('libs/bootstrap/dist/js/bootstrap.min.js') }}"></script>

@include('includes.express.footer')

@yield('javascript')

</body>
</html>
