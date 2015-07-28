@extends('app')

@section('title', 'Your Sold books')

@section('css')
    <link href="{{ asset('/css/order_index.css') }}" rel="stylesheet">
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
        @forelse ($orders as $order)
            <div class="row">
                <div class="container order-container">
                    <div class="row order-row">
                        <div class="col-xs-12 col-sm-2 order-date">
                            <h5>Order Sold</h5>

                            <p>{{ date('M d, Y', strtotime($order->created_at)) }}</p>
                        </div>
                        <div class=" col-xs-12 col-sm-2 col-xs-offset-0 order-total">
                            <h5>Total</h5>
                            <p>${{ $order->product->price }}</p>
                        </div>
                        <div class="col-xs-12 col-sm-3 col-sm-offset-5 order-number">
                            <h5>Order Number # {{ $order->id}}</h5>
                            <a id="show-order-link" href="/order/seller/{{$order->id}}">View Order Details <i
                                        class="fa fa-caret-right"></i></a>
                        </div>
                    </div>

                    <!-- order status -->
                    <div class="alert-container">
                        <span id="cancelled">
                            <h3>{{ $order->getOrderStatus()['status'] }}</h3>
                            <small>{{ $order->getOrderStatus()['detail'] }}</small>
                        </span>
                    </div>

                    <div class="row book-row">
                        <div class="col-xs-12 col-sm-2 book-img">
                            <a href="{{ url('/textbook/buy/product/'.$order->product->id) }}">
                                <img class="lg-img" src="{{$order->product->book->imageSet->large_image}}">
                            </a>
                        </div>
                        <div class="col-xs-12 col-sm-5 book-info">
                            <h5><a href="{{ url('/textbook/buy/product/'.$order->product->id) }}">{{ $order->product->book->title }}</a></h5>
                            <h5><small>{{ $order->product->book->author}}</small></h5>
                            <h6>ISBN: {{ $order->product->book->isbn10 }}</h6>
                            <h6 class="book-price">${{ $order->product->price }}</h6>
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
@endsection