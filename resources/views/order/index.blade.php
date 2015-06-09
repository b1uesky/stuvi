@extends('app')

@section('content')
    <head>
        <link href="{{ asset('/css/order.css') }}" rel="stylesheet">
        <title>Your Orders</title>
    </head>

    <div class="container" xmlns="http://www.w3.org/1999/html">
        @if (Session::has('message'))
            <div class="flash-message">{{ Session::get('message') }}</div>
        @endif
    </div>
    <div class="container buyer-order-container">
        <h1>Your orders:</h1>
        @forelse ($orders as $order)
            <div class="row">
                <div class="container order-container">
                    <div class="row book-row">
                        <div class="col-xs-2 col-xs-offset-1">
                            <img src="http://placehold.it/100x100">
                        </div>
                        <div class="col-xs-5 book-info">
                            <h3>The Catcher in the Rye</h3>
                            <h4>J.D. Salinger</h4>

                            <p>9788976100146</p>
                        </div>
                        <div class="col-xs-2 col-xs-offset-2 book-price">
                            <h4>$10.00</h4>
                        </div>
                    </div>
                    <div class="row order-row">
                        <div class="col-xs-2 col-xs-offset-1 order-date">
                            <h5>Order Placed</h5>

                            <p>June 12, 2015</p>
                        </div>
                        <div class="col-xs-3 col-xs-offset-2 order-number">
                            <h5>Order Number</h5>

                            <p>0123456789</p>
                        </div>
                        <div class="col-xs-2 col-xs-offset-2 order-total">
                            <h5>Total</h5>

                            <p>$10.00</p>
                        </div>
                    </div>
                </div>

                {{--<li><a href="{{ url('order/buyer/'.$order->id) }}">Order #{{ $order->id }}</a></li>--}}
                {{----}}
                {{--<li>{{ $order->buyer_payment()->stripe_amount/100 }}</li>--}}
                {{--<p>Product info:</p><br>--}}
                {{--<li>{{ $order->product->book->title }}</li>--}}
                {{--<li>{{ $order->product->book->isbn }}</li>--}}
                {{--<li>{{ $order->product->book->author }}</li>--}}
                {{----}}
                {{----------------------------------------------------------------<br>--}}
            </div>
        @empty
            <p>You don't have any orders.</p>
        @endforelse

    </div>
@endsection