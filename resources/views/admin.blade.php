<!DOCTYPE html>
<html>

@section('title', 'Home')

@include('includes.admin.head')

<body>

<section class="menu">
    @include('includes.admin.header')
</section>

<section class="content">
    @yield('content')
</section>

@include('includes.admin.footer')

@yield('javascript')

</body>
</html>
