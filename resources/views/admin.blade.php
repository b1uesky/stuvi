<!DOCTYPE html>
<html>
<head>
    <title>Admin</title>
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('/css/admin.css') }}"/>
</head>
<body>

    <nav class="navbar navbar-default">
        <div class="navbar-header">
            <a class="navbar-brand" href="{{ URL::to('admin') }}">Admin</a>
        </div>
        <ul class="nav navbar-nav">
            <li><a href="{{ URL::to('admin/user') }}">User</a></li>
            <li><a href="{{ URL::to('admin/product') }}">Product</a></li>
        </ul>
    </nav>

@yield('content')

</body>
</html>
