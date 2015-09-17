@extends('layouts.textbook')

@section('title', 'Order #'.$buyer_order->id)

@section('content')

    <div class="container">
        <div class="row">
            <ol class="breadcrumb">
                <li><a href="{{ url('textbook') }}">Home</a></li>
                <li><a href="{{ url('order/buyer') }}">Your orders</a></li>
                <li class="active">Order #{{ $buyer_order->id }}</li>
            </ol>
        </div>

        <div class="page-header">
            <h1>Order Details</h1>
        </div>

        <div class="panel panel-default">
            <div class="panel-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-4">
                            <span>Ordered on {{ $buyer_order->created_at }}</span>
                        </div>
                        <div class="col-md-2">
                            <span>Order #{{ $buyer_order->id }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- order details --}}
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <?php $addr = $buyer_order->shipping_address ?>

                            <div class="row">
                                <h4>Shipping Address</h4>
                            </div>
                            <div class="row">
                                <span>{{ $addr->addressee }}</span>
                            </div>
                            <div class="row">
                                <span>{{ $addr->address_line1 }}</span>
                            </div>
                            <div class="row">
                                <span>{{ $addr->city }}</span>, <span>{{ $addr->state_a2 }}</span> <span>{{ $addr->zip }}</span>
                            </div>
                        </div>

                        {{--<div class="col-md-4">--}}
                            {{--<div class="row">--}}
                                {{--<h4>Payment Method</h4>--}}
                            {{--</div>--}}

                            {{--<div class="row">--}}
                                 {{--TODO--}}
                            {{--</div>--}}
                        {{--</div>--}}

                        <div class="col-sm-6">
                            @if(!$buyer_order->cancelled)
                                <div class="row">
                                    <h4>Order Summary</h4>
                                </div>

                                <div class="row">
                                    <span class="pull-left">Item(s) subtotal:</span>
                                    <span class="pull-right">${{ $buyer_order->decimalSubtotal() }}</span>
                                </div>

                                <div class="row">
                                    <span class="pull-left">Shipping & Handling:</span>
                                    <span class="pull-right">${{ $buyer_order->decimalShipping() }}</span>
                                </div>

                                <div class="row">
                                    <span class="pull-left">Discount:</span>
                                    <span class="pull-right">-${{ $buyer_order->decimalDiscount() }}</span>
                                </div>

                                <div class="row">
                                    <span class="pull-left">Total before tax:</span>
                                    <span class="pull-right">${{ $buyer_order->decimalSubtotal() + $buyer_order->decimalShipping() - $buyer_order->decimalDiscount() }}</span>
                                </div>

                                <div class="row">
                                    <span class="pull-left">Estimated tax to be collected:</span>
                                    <span class="pull-right">${{ $buyer_order->decimalTax() }}</span>
                                </div>

                                <div class="row">
                                    <span class="pull-left"><strong>Grand Total:</strong></span>
                                    <span class="pull-right"><strong>${{ $buyer_order->decimalAmount() }}</strong></span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-body">
                <div class="container-fluid">
                    {{-- order status --}}
                    <div class="row">
                        <h3>{{ $buyer_order->getOrderStatus()['status'] }}</h3>
                        <span>{{ $buyer_order->getOrderStatus()['detail'] }}</span>
                    </div>

                    <br>

                    <div class="row">
                        <div class="col-md-9">
                            <!-- product list -->
                            @foreach($buyer_order->seller_orders as $seller_order)
                                <?php $product = $seller_order->product; ?>

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

                                        @if($seller_order->isCancelledBySeller())
                                            <br>
                                            <div class="row text-muted">
                                                <span class="glyphicon glyphicon-info-sign"></span> Cancelled by seller
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <br>
                            @endforeach
                        </div>

                        {{-- action buttons --}}
                        <div class="col-md-3">

                            {{-- cancel order --}}
                            @if ($buyer_order->isCancellable())
                                <button type="button" class="btn btn-danger btn-block" data-toggle="modal"
                                        data-target="#cancel-buyer-order"
                                        data-buyer-order-id="{{ $buyer_order->id }}">Cancel order</button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection

@include('includes.modal.cancel-buyer-order')

@section('javascript')
    <script src="{{ asset('js/order/buyer/show.js') }}"></script>
@endsection