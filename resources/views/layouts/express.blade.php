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
@include('includes.express.js')

</body>
</html>
