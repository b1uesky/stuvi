{{-- The bookshelf page shows all the seller's books for sale, but not yet purchased --}}

@extends('app')

@section('content')
    <head>
        <title>Stuvi - Bookshelf</title>
        <link rel="stylesheet" type="text/css" href="{{asset('/css/user/bookshelf.css')}}">
    </head>

    <div class="container-fluid bookshelf-page">
        <div class="container message-cont" xmlns="http://www.w3.org/1999/html">
            @if (Session::has('message'))
                <div class="flash-message message">{{ Session::get('message') }}</div>
            @endif
        </div>
        <!-- back button -->
        <a id="btn-back" href="javascript:history.back()"><i class="fa fa-arrow-circle-left"></i>Back</a>

        <!-- search bar-->


        <!-- user info -->
        <div class="container">
            <h1>Your Bookshelf
                <small><a href="/user/profile">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</a>
                    <i class="fa fa-star" id="reputation"></i>(<a href="#">80</a>)
                </small>
            </h1>
            <hr id="hr1">
        </div>

        <!-- sort and search -->
        <div class="container">
            <span class="text-muted">Sort by</span>
            <ul class="nav nav-pills">
                <li role="presentation"><a href="#">Title</a></li>
                <li role="presentation"><a href="#">Author</a></li>
                <li role="presentation"><a href="#">Price (Low to High)</a></li>
                <li role="presentation"><a href="#">Price (High to Low)</a></li>

                <div class="col-sm-4 col-md-4 pull-right bookshelf-sort">
                    <form class="navbar-form" role="search">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search" name="srch-term"
                                   id="srch-term">

                            <div class="input-group-btn">
                                <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

            </ul>

        </div>

        <!-- books -->
        <div class="container">
            <table class="table table-responsive for-sale-table">
                @forelse ($productsForSale as $product)
                    <tr class="for-sale-item">
                        <td class="for-sale-img">
                            <img class="img-responsive" src="{{ url($product->images()->first()->path) }}" width="100px"
                                 height="150px"></td>
                        <td class="for-sale-info-1">
                            <span class="for-sale-title"><a
                                        href="{{ url('textbook/buy/product/'.$product->id) }}">{{ $product->book->title }}</a></span><br>
                            <span>by </span>
                            @foreach($product->book->authors as $author)
                                <span class="for-sale-author"><a href="#">{{ $author->full_name }}</a></span>
                            @endforeach

                            <span class="for-sale-binding">Hardcover</span><br>
                            <span class="for-sale-price">{{ $product->price }}</span> <br>
                        </td>
                        <td class="for-sale-info-2">
                            <span class="for-sale-isbn">ISBN-10: {{ $product->book->isbn10 }}</span><br>
                            <span class="for-sale-isbn">ISBN-13: {{ $product->book->isbn13 }}</span>
                        </td>

                        <td class="for-sale-info-3">
                            <!-- each class the book support -->
                            <h5>Classes</h5>
                            <span class="for-sale-class"><a href="#">BU:SMG SM131</a></span>
                        </td>
                    </tr>
                @empty
                    You don't have book for sale.
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
@endsection

@section('javascript')
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
@endsection