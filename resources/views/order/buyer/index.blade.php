<!-- http://homestead.app/order/buyer -->

@extends('app')

@section('title', 'Your orders')

@section('css')
    <link href="{{ asset('/css/order_index.css') }}" rel="stylesheet">
@endsection

@section('content')

    @include('includes.textbook.flash-message')
        
    <!-- main container -->
    <div class="container buyer-order-container">
        <h1>Your orders</h1>
        @forelse ($orders as $order)
            <div class="row">
                <div class="container order-container">
                    <div class="row order-row">
                        <!-- order details -->
                        <div class="col-xs-2 order-date">
                            <h5>Order Placed</h5>

                            <p>{{ date('M d, Y', strtotime($order->created_at)) }}</p>
                        </div>

                        <div class="col-xs-2 order-total">
                            <h5>Total</h5>
                            <p>${{ $order->amount/100 }}</p>
                        </div>
                        <div class="col-xs-3 col-xs-offset-5 order-number">
                            <h5>Order Number # {{ $order->id }}</h5>
                            <a id="show-order-link" href="/order/buyer/{{$order->id}}">View Order Details <i
                                        class="fa fa-caret-right"></i>
                            </a>
                        </div>
                    </div>
                    <!-- order status -->

                    <span id="cancelled">
                        <h3>{{ $order->getOrderStatus()['status'] }}</h3>
                        <small>{{ $order->getOrderStatus()['detail'] }}</small>
                    </span>
                    @if ($order->isCancellable())
                        <a class="btn secondary-btn" href="/order/buyer/cancel/{{ $order->id }}" role="'button">Cancel Order</a>
                    @endif
                    <!-- products in order -->
                    @forelse($order->products() as $product)
                        <div class="row book-row">
                            <div class="col-xs-12 col-sm-2 book-img">
                                <a href="{{ url('/textbook/buy/product/'.$product->id) }}">
                                    @if($product->book->imageSet->large_image)
                                        <img class="lg-img" src="{{ config('aws.url.stuvi-book-img') . $product->book->imageSet->large_image}}">
                                    @else
                                        <img class="lg-img" src="{{ config('book.default_image_path.large') }}">
                                    @endif
                                </a>
                            </div>
                            <div class="col-xs-12 col-sm-5 book-info">
                                <a href="{{ url('/textbook/buy/product/'.$product->id) }}">
                                    <h5>{{ $product->book->title }}</h5>
                                </a>
                                <h5><small>{{ $product->book->author}}</small></h5>

                                <p>ISBN: {{ $product->book->isbn10 }}</p>
                                <h6 class="book-price">${{ $product->decimalPrice() }}</h6>
                            </div>
                        </div>
                    @empty
                        <div class="row book-row-empty bg-warning">
                            <span>There has been a problem.</span>
                        </div>
                    @endforelse
                </div>
            </div>
        @empty
            <div class="container-fluid empty">
                <p>You don't have any orders.
                Why not <a href="/textbook">make one</a>?</p>
            </div>
        @endforelse
    </div>
@endsection

@section('javascript')
@endsection