<div class="panel panel-default">

    <div class="list-group">

        {{-- toggle menu item active state depending on the url --}}
        <a class="list-group-item {{ Request::segment(2) == 'user' ? 'active' : '' }}" href="{{ url('admin/user') }}">
            User <span class="badge">{{ \App\User::count() }}</span>
        </a>

        <a class="list-group-item {{ Request::segment(2) == 'book' ? 'active' : '' }}" href="{{ url('admin/book') }}">
            Book <span class="badge">{{ \App\Book::count() }}</span>
        </a>

        <a class="list-group-item {{ Request::segment(2) == 'product' ? 'active' : '' }}" href="{{ url('admin/product') }}">
            Product <span class="badge">{{ \App\Product::count() }}</span>
        </a>

        <a class="list-group-item {{ Request::segment(2) == 'order' && Request::segment(3) == 'seller' ? 'active' : '' }}" href="{{ url('admin/order/seller') }}">
            Seller order <span class="badge">{{ \App\SellerOrder::count() }}</span>
        </a>

        <a class="list-group-item {{ Request::segment(2) == 'order' && Request::segment(3) == 'buyer' ? 'active' : '' }}" href="{{ url('admin/order/buyer') }}">
            Buyer order <span class="badge">{{ \App\BuyerOrder::count() }}</span>
        </a>

        <a class="list-group-item {{ Request::segment(2) == 'order' }}" href="{{ url('admin/donation') }}">
            Donation <span class="badge">{{ \App\Donation::count() }}</span>
        </a>

        <a class="list-group-item {{ Request::segment(2) == 'textbookReminder' }}" href="{{ url('admin/textbookReminder') }}">
            Textbook reminder <span class="badge">{{ \App\BookReminder::count() }}</span>
        </a>

    </div>

</div>