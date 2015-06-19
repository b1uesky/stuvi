
{{--http://homestead.app/order/seller--}}

@extends('app')

@section('content')
    <head>
        <link href="{{ asset('/css/order.css') }}" rel="stylesheet">
        <title>Stuvi - Sold Books</title>
    </head>

    <div class="row back-row">
        <a id="go-back" href="" onclick="goBack()" ><i class="fa fa-arrow-circle-left"></i> Back</a>
    </div>

    <div class="container" xmlns="http://www.w3.org/1999/html">
        @if (Session::has('message'))
            <div class="flash-message">{{ Session::get('message') }}</div>
        @endif
    </div>
    <div class="container">
        <h1>Your sold books:</h1>
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
                            <img class="lg-img" src="{{ $order->product->images->first()->path }}">
                        </div>
                        <div class="col-xs-12 col-sm-5 book-info">
                            <h5>{{ $order->product->book->title }}</h5>
                            <h5><small>{{ $order->product->book->author}}</small></h5>
                            <h6>ISBN: {{ $order->product->book->isbn }}</h6>
                        </div>
                        <div class="col-xs-12 col-sm-2 col-xs-offset-0 col-sm-offset-1 col-md-offset-3 book-price">
                            <h4>${{ $order->product->price }}</h4>
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

    <script>
        function goBack() {
            window.history.back();
        }
    </script>
@endsection