<!DOCTYPE html>
<html>
<head>
    <title>Delivery</title>
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
    {{--<link rel="stylesheet" href="{{ asset('/css/delivery.css') }}"/>--}}
</head>
<body>

<nav class="navbar navbar-default">
    <div class="navbar-header">
        <a class="navbar-brand" href="{{ URL::to('delivery') }}">Admin</a>
    </div>

    <ul class="nav navbar-nav">
        <li><a href="{{ URL::to('admin/user') }}">User</a></li>
        <li><a href="{{ URL::to('admin/product') }}">Product</a></li>
        <li><a href="{{ URL::to('admin/sellerOrder') }}">SellerOrder</a></li>
    </ul>

    <ul class="nav navbar-nav navbar-right">
        <li><a href="#">{{ Auth::user()->first_name }}</a></li>
    </ul>
</nav>

@yield('content')

</body>
</html>
