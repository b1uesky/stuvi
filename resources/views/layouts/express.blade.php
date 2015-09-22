<!DOCTYPE html>
<html>

@section('title', 'Home')

@include('includes.express.head')

<body>

@include('includes.express.header')

@include('includes.alerts')

<div class="container">
    <div class="row page-content">
        @yield('content')
    </div>
</div>


@include('includes.express.footer')

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

<script src="{{ asset('libs/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('libs/bootstrap/dist/js/bootstrap.min.js') }}"></script>

<script src="{{ asset('js/alert.js') }}"></script>


@yield('javascript')

</body>
</html>
