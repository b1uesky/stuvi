<header>
    <ul class="nav nav-pills nav-stacked">
        <li>
            <a href="{{ URL::to('admin') }}">Home</a>
        </li>
        <li>
            <a href="{{ URL::to('admin/user') }}">
                User <span class="badge">{{ \App\User::count() }}</span>
            </a>
        </li>
        <li>
            <a href="{{ URL::to('admin/product') }}">
                Product <span class="badge">{{ \App\Product::count() }}</span>
            </a>
        </li>
        <li>
            <a href="{{ URL::to('admin/order/seller') }}">
                SellerOrder <span class="badge">{{ \App\SellerOrder::count() }}</span>
            </a>
        </li>
        <li>
            <a href="{{ URL::to('admin/order/buyer') }}">
                BuyerOrder <span class="badge">{{ \App\BuyerOrder::count() }}</span>
            </a>
        </li>
        <li>
            <a href="{{ URL::to('admin/contact') }}">
                Contact <span class="badge">{{ \App\Contact::where('is_replied', false)->count() }}</span>
            </a>
        </li>
    </ul>
</header>