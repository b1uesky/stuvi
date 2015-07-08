<!DOCTYPE html>
<html>

@section('title', 'Home')

@include('includes.express.head')

<body>

@include('includes.express.header')

@yield('content')

<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>

@include('includes.express.footer')

@yield('javascript')

</body>
</html>
