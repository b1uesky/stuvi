<!-- http://homestead.app/order/buyer -->


@extends('app')

@section('content')
    <head>
        <link href="{{ asset('/css/order.css') }}" rel="stylesheet" type="text/css">
        <title>Stuvi - Your Orders</title>
    </head>

    <div class="container" id="message-cont" xmlns="http://www.w3.org/1999/html">
        @if (Session::has('message'))
            <div class="flash-message" id="message" >{{ Session::get('message') }}</div>
        @endif
    </div>
    <div class="container buyer-order-container">
        <h1>Your orders</h1>
        @forelse ($orders->reverse() as $order)
            <div class="row">
                <div class="container order-container">
                    <div class="row order-row">
                        <div class="col-xs-12 col-sm-2 order-date">
                            <h5>Order Placed</h5>

                            <p>{{ date('M d, Y', strtotime($order->created_at)) }}</p>
                        </div>

                        <div class=" col-xs-12 col-sm-2 col-xs-offset-0 order-total">
                            <h5>Total</h5>
                            <p>${{ $order->buyer_payment['stripe_amount']/100 }}</p>
                        </div>
                        <div class="col-xs-12 col-sm-3 col-sm-offset-5 order-number">
                            <h5>Order Number # {{ $order->id }}</h5>
                            <a href="/order/buyer/{{$order->id}}">View Order Details <i class="fa fa-caret-right"></i>
                            </a>
                        </div>
                    </div>
                    <!-- order status -->
                    @if ($order->cancelled)
                        <span id="cancelled"> <h3>Order Canceled</h3>
                        <small>Your order has been cancelled.</small>
                        </span>
                    @elseif ($order->pickup_time)
                        <h3>Delivered</h3>
                        <small>Delivered at {{ date($datetime_format, strtotime($order->pickup_time)) }}</small>
                    @else
                        <h3>Order Processing</h3>
                        <small>Your order is being processed by the Stuvi team.</small>
                    @endif
                    @foreach($order->products() as $product)
                        <div class="row book-row">
                            <div class="col-xs-12 col-sm-2 book-img">
                                <img class="lg-img" src="{{$product->book->imageSet->large_image}}">
                            </div>
                            <div class="col-xs-12 col-sm-5 book-info">
                                <h5>{{ $product->book->title }}</h5>
                                <h5><small>{{ $product->book->author}}</small></h5>

                                <p>{{ $product->book->isbn }}</p>
                                <h6 id="book-price">${{ $product->price }}</h6>
                            </div>
                            <div class=" col-xs-12 col-sm-2 col-xs-offset-0 col-sm-offset-1 col-md-offset-3">
                                {{--<a class="btn btn-default order-button-1" href="#" role="button">Track Package</a>--}}
                                <a class="btn btn-default order-button-2" href="#" role="button">Return or Replace Item</a>
                                <a class="btn btn-default order-button-2" href="#" role="button">Leave Seller Feedback</a>
                        </div>


                        </div>
                    @endforeach

                </div>
            </div>
        @empty
            <p>You don't have any orders.</p>
        @endforelse

    </div>
@endsection