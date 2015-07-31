<header>
    <ul class="nav nav-pills nav-stacked">
        <li><a href="{{ URL::to('admin') }}">Home</a></li>
        <li><a href="{{ URL::to('admin/user') }}">User</a></li>
        <li><a href="{{ URL::to('admin/product') }}">Product</a></li>
        <li><a href="{{ URL::to('admin/order/seller') }}">SellerOrder</a></li>
        <li><a href="{{ URL::to('admin/order/buyer') }}">BuyerOrder</a></li>
        <li><a href="{{ URL::to('admin/contact') }}">Contact</a></li>
    </ul>
</header>