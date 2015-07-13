<header>
    <nav class="navbar navbar-default">
        <div class="navbar-header">
            <a class="navbar-brand" href="{{ URL::to('admin') }}">Admin</a>
        </div>

        <ul class="nav navbar-nav">
            <li><a href="{{ URL::to('admin/user') }}">User</a></li>
            <li><a href="{{ URL::to('admin/product') }}">Product</a></li>
            <li><a href="{{ URL::to('admin/order/seller') }}">SellerOrder</a></li>
            <li><a href="{{ URL::to('admin/order/buyer') }}">BuyerOrder</a></li>
        </ul>

        <ul class="nav navbar-nav navbar-right">
            <li><a href="#">{{ Auth::user()->first_name }}</a></li>
        </ul>
    </nav>
</header>