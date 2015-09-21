<!DOCTYPE html>
<html>

@section('title', 'Home')

@include('includes.admin.head')

<body>

<div class="container-fluid">
    <div class="row page-content">
        <div class="col-md-2">
            @include('includes.admin.header')
        </div>

        <div class="col-md-10">
            @yield('content')
        </div>
    </div>
</div>

@include('includes.admin.footer')

@yield('javascript')

</body>
</html>
