
{{--http://homestead.app/order/seller--}}

@extends('app')

@section('title', 'Your Sold books')

@section('css')
    <link href="{{ asset('/css/order/order.css') }}" rel="stylesheet">
@endsection

@section('content')

    <!-- Message -->
    <div class="container" xmlns="http://www.w3.org/1999/html">
        @if (Session::has('message'))
            <div class="flash-message">{{ Session::get('message') }}</div>
        @endif
    </div>
    <!-- Main container -->
    <div class="container seller-order-container">
        <h1>Your sold books</h1>
        @forelse ($orders->reverse() as $order)
            <div class="row">
                <div class="container order-container">
                    <div class="row order-row">
                        <div class="col-xs-12 col-sm-2 order-date">
                            <h5>Order Sold</h5>

                            <p>{{ date('M d, Y', strtotime($order->created_at)) }}</p>
                        </div>
{{--
                        <div class=" col-xs-12 col-sm-2 col-xs-offset-0 order-total">
                            <h5>Total</h5>
                            <p>${{ $order->seller_payment['stripe_amount']/100 }}</p>--}}

                        <div class="col-xs-12 col-sm-3 col-sm-offset-7 order-number">
                            <h5>Order Number # {{ $order->id}}</h5>
                            <a href="/order/seller/{{$order->id}}">View Order Details <i class="fa fa-caret-right"></i></a>
                        </div>
                    </div>
                    <div class="row book-row">
                        <div class="col-xs-12 col-sm-2 book-img">
                            <a href="{{ url('/textbook/buy/product/'.$order->product->id) }}">
                                <img class="lg-img" src="{{ $order->product->images->first()->path }}">
                            </a>
                        </div>
                        <div class="col-xs-12 col-sm-5 book-info">
                            <h5><a href="{{ url('/textbook/buy/product/'.$order->product->id) }}">{{ $order->product->book->title }}</a></h5>
                            <h5><small>{{ $order->product->book->author}}</small></h5>
                            <h6>ISBN: {{ $order->product->book->isbn10 }}</h6>
                        </div>
                        <div class="col-xs-12 col-sm-2 col-xs-offset-0 col-sm-offset-3 col-md-offset-3 book-price">
                            <h4>${{ $order->product->price }}</h4>
                        </div>
                    </div>

                </div>
            </div>
        @empty
            <div class="container-fluid empty">
                <div class="">
                    <p>You haven't sold any books. Why not <a href="{{ url('/textbook/sell') }}">sell some</a>?</p>
                </div>
            </div>
        @endforelse

    </div>
@endsection

@section('javascript')
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
@endsection