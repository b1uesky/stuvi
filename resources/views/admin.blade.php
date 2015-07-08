<!DOCTYPE html>
<html>

@section('title', 'Home')

@include('includes.admin.head')

<body>

@include('includes.admin.header')

@yield('content')

@include('includes.admin.footer')

@yield('javascript')

</body>
</html>
