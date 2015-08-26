<!-- http://homestead.app/order/buyer -->

@extends('layouts.textbook')

@section('title', 'Your orders')

@section('content')

    <div class="container">
        <div class="page-header">
            <h1>Your orders</h1>
        </div>

        {{-- order list --}}
        @foreach ($orders as $buyer_order)
            <div class="panel panel-default">
                <div class="panel-heading">

                    {{-- order details --}}
                    <div class="container-fluid text-muted">
                        <div class="col-xs-2">
                            <div class="row">
                                <span>ORDER PLACED</span>
                            </div>

                            <div class="row">
                                <span>{{ date('M d, Y', strtotime($buyer_order->created_at)) }}</span>
                            </div>
                        </div>

                        <div class="col-xs-2">
                            <div class="row">
                                <span>TOTAL</span>
                            </div>

                            <div class="row">
                                <span>${{ $buyer_order->decimalAmount() }}</span>
                            </div>
                        </div>

                        <div class="col-xs-2 col-xs-offset-6 text-right">
                            <div class="row">
                                <span>ORDER #{{ $buyer_order->id }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel-body">
                    <div class="container-fluid">
                        {{-- order status --}}
                        <div class="row">
                            <h3>{{ $buyer_order->getOrderStatus()['status'] }}</h3>
                            <small>{{ $buyer_order->getOrderStatus()['detail'] }}</small>
                        </div>

                        <br>

                        <div class="row">
                            <div class="col-md-9">
                                <!-- product list -->
                                @foreach($buyer_order->products() as $product)
                                    <div class="row">

                                        {{-- book image --}}
                                        <div class="col-md-2">
                                            <a href="{{ url('/textbook/buy/product/'.$product->id) }}">
                                                @if($product->book->imageSet->small_image)
                                                    <img class="img-responsive img-small"
                                                         src="{{ config('aws.url.stuvi-book-img') . $product->book->imageSet->small_image}}">
                                                @else
                                                    <img class="img-responsive img-small"
                                                         src="{{ config('book.default_image_path.large') }}">
                                                @endif
                                            </a>
                                        </div>

                                        {{-- book details --}}
                                        <div class="col-md-10">
                                            <div class="row">
                                                <span>
                                                    <a href="{{ url('/textbook/buy/product/'.$product->id) }}">{{ $product->book->title }}</a>
                                                </span>
                                            </div>

                                            <div class="row">
                                                <span>ISBN-10: {{ $product->book->isbn10 }}</span>
                                            </div>

                                            <div class="row">
                                                <span>ISBN-13: {{ $product->book->isbn13 }}</span>
                                            </div>

                                            <div class="row">
                                                <span class="price">${{ $product->decimalPrice() }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                @endforeach
                            </div>

                            {{-- action buttons --}}
                            <div class="col-md-3">
                                {{-- order details --}}
                                <a class="btn btn-primary btn-block" href="/order/buyer/{{$buyer_order->id}}">Order
                                    Details</a>

                                {{-- cancel order --}}
                                @if ($buyer_order->isCancellable())
                                    <a class="btn btn-secondary btn-block cancel-order-btn" href="/order/buyer/cancel/{{ $buyer_order->id }}"
                                       role="button">Cancel Order</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection