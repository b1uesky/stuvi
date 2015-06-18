@extends('app')

@section('content')
    <head>
        <link href="{{ asset('/css/order.css') }}" rel="stylesheet">
        <title>Sold Books</title>
    </head>

    <div class="container" xmlns="http://www.w3.org/1999/html">
        @if (Session::has('message'))
            <div class="flash-message">{{ Session::get('message') }}</div>
        @endif
    </div>
    <div class="container">
        <h1>Your sold books:</h1>
        @forelse ($orders as $order)
            <div class="row">
                <div class="container order-container">
                    <div class="row book-row">
                        <div class="col-xs-2 col-xs-offset-1">
                            <img src="{{ $order->product->images->first()->path }}" width="150" height="200">
                        </div>
                        <div class="col-xs-5 book-info">
                            <h3>{{ $order->product->book->title }}</h3>
                            <h4>{{ $order->product->book->author}}</h4>
                            <p>ISBN: {{ $order->product->book->isbn }}</p>
                        </div>
                        <div class="col-xs-2 col-xs-offset-2 book-price">
                            <h4>${{ $order->product->price }}</h4>
                        </div>
                    </div>
                    <div class="row order-row">
                        <div class="col-xs-2 col-xs-offset-1 order-date">
                            <h5>Order Sold</h5>

                            <p>{{ date('M d, Y', strtotime($order->created_at)) }}</p>
                        </div>
                        <div class="col-xs-3 col-xs-offset-2 order-number">
                            <h5>Order Number</h5>

                            <p>{{ $order->id}}</p>
                        </div>
                    </div>
                </div>


                {{--<li>Order #{{ $order->id }}</li>--}}
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
            <div class="empty">
                <p>You haven't sold any books.</p>
                <a href="{{ url('/textbook/sell') }}">Sell a book</a>
            </div>
        @endforelse

    </div>
@endsection