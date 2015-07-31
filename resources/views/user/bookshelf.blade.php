{{-- The bookshelf page shows all the seller's books for sale, but not yet purchased --}}

@extends('app')

@section('title','Bookshelf')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('/css/user_bookshelf.css')}}">
@endsection

@section('content')
    @include('user-template')

    <div class="col-md-9 bookshelf-page">
        <div class="profile-content bookshelf-content">
            <div class="container message-cont" xmlns="http://www.w3.org/1999/html">
                @if (Session::has('message'))
                    <div class="flash-message message">{{ Session::get('message') }}</div>
                @endif
            </div>
            <div class="bookshelf-title-container">
                <h1 id="bookshelf-title">Your Bookshelf</h1>
                <hr>
            </div>
            <!-- sort and search -->
            {{--<div class="container col-sm-12">--}}
                {{--<span class="text-muted">Sort by</span>--}}
            {{--<ul class="nav nav-pills">--}}
                    {{--<li role="presentation" class="active"><a href="#" data-toggle="pill">Title</a></li>--}}
                    {{--<li role="presentation"><a href="#" data-toggle="pill">Author</a></li>--}}
                    {{--<li role="presentation"><a href="#" data-toggle="pill">Price (Low to High)</a></li>--}}
                    {{--<li role="presentation"><a href="#" data-toggle="pill">Price (High to Low)</a></li>--}}

            {{--<div class="col-sm-4 pull-right bookshelf-sort">--}}
            {{--<form class="navbar-form" role="search">--}}
            {{--<div class="input-group">--}}
            {{--<input type="text" class="form-control" placeholder="Search" name="srch-term"--}}
            {{--id="search-term">--}}

            {{--<div class="input-group-btn">--}}
            {{--<button class="btn btn-default search-btn" type="submit">--}}
            {{--<i class="fa fa-search search-icon"></i>--}}
            {{--</button>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--</form>--}}
            {{--</div>--}}
            {{--</ul>--}}
            {{--</div>--}}

            <!-- books -->
            <div class="container col-md-12">
                <table class="table table-responsive for-sale-table">
                    @forelse ($productsForSale as $product)
                        <tr class="for-sale-item">
                            <td class="for-sale-img">
                                <img class="img-responsive" src="{{ config('aws.url.stuvi-product-img').$product->images->first()->small_image }}"
                                     width="100px"
                                     height="150px"></td>
                            <td class="for-sale-info-1" colspan="2">
                            <span class="for-sale-title"><a
                                        href="{{ url('textbook/buy/product/'.$product->id) }}">{{ $product->book->title }}</a></span><br>
                                <span>by </span>
                                @foreach($product->book->authors as $author)
                                    <span class="for-sale-author">{{ $author->full_name }}</span>
                                @endforeach

                                <span class="for-sale-binding">Hardcover</span><br>
                                <span class="for-sale-price">${{ $product->price/100 }}</span> <br>
                            </td>
                            <td class="for-sale-info-2">
                                <span class="for-sale-isbn">ISBN-10: {{ $product->book->isbn10 }}</span><br>
                                <span class="for-sale-isbn">ISBN-13: {{ $product->book->isbn13 }}</span>
                            </td>

                            {{--<td class="for-sale-info-3">--}}
                            {{--<!-- each class the book support -->--}}
                            {{--<h5>Classes</h5>--}}
                            {{--<span class="for-sale-class"><a href="#">BU:SMG SM131</a></span>--}}
                            {{--</td>--}}
                        </tr>
                    @empty
                        <div class="empty"><br>You don't have books for sale.</div>
                    @endforelse
                </table>
            </div>
            {{--        <h1>Your buyer orders:</h1>
                    @forelse ($orders as $order)
                        <div class="row">
                        <li><a href="{{ url('order/buyer/'.$order->id) }}">Order #{{ $order->id }}</a></li>
                            --}}{{--
                        <li>{{ $order->buyer_payment()->stripe_amount/100 }}</li>
                        <p>Product info:</p><br>
                        <li>{{ $order->product->book->title }}</li>
                        <li>{{ $order->product->book->isbn }}</li>
                        <li>{{ $order->product->book->author }}</li>
                        --}}{{--
                        --------------------------------------------------------------<br>
                        </div>
                    @empty
                        <p>You don't have any orders.</p>
                    @endforelse--}}
        </div>
    </div>
    {{--need these closing tags--}}
    </div>
    </div>
    </div>
@endsection

@section('javascript')
    <script type="text/javascript" src="{{asset('js/user/bookshelf.js')}}"></script>
@endsection