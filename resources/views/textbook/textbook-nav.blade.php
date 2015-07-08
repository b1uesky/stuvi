@section('nav')
    <link href="{{ asset('/css/textbook/textbook-nav.css') }}" rel="stylesheet">

    {{--textbook navigation bar--}}
    <div class="tab-filter-container">
        <ul class="tab-filters">
            <li class="filter active">
                <a class="filter-link active" href="{{ url('/textbook/buy') }}">Buy</a>
            </li>
            <li class="filter">
                <a class="filter-link" href="{{ url('/textbook/sell') }}">Sell</a>
            </li>
            <li class="cart">
                <a href="{{ url('/cart') }}" class="cart-link"><i class="fa fa-shopping-cart fa-2x"></i></a>
            </li>
        </ul>
    </div>
@show
@yield('content')
