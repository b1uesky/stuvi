@extends('app')

@section('title', 'Order #'.$buyer_order->id)

@section('css')
    <link href="{{ asset('/css/order_show.css') }}" rel="stylesheet">
@endsection

@section('content')

            <!-- order details -->
    <div class="container container-main-content">
        {!! Breadcrumbs::render() !!}

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

        {{-- TODO: show status of scheduled pickup or not--}}
        {{--<p>Scheduled pickup time:--}}
            {{--@if ($seller_order->scheduled_pickup_time)--}}
                {{--{{ date($datetime_format, strtotime($seller_order->scheduled_pickup_time)) }}--}}
            {{--@else--}}
                {{--N/A--}}
            {{--@endif--}}
        {{--</p>--}}

        {{--<p>Pickup time:--}}
            {{--@if ($seller_order->pickup_time)--}}
                {{--{{ date($datetime_format, strtotime($seller_order->pickup_time)) }}--}}
            {{--@else--}}
                {{--N/A--}}
            {{--@endif--}}
        {{--</p>--}}

        {{-- order details --}}
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-4">
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

                        <div class="col-md-4">
                            <div class="row">
                                <h4>Payment Method</h4>
                            </div>

                            <div class="row">
                                 {{--TODO--}}
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="row">
                                <h4>Order Summary</h4>
                            </div>

                            <div class="row">
                                <span class="pull-left">Item(s) subtotal:</span>
                                <span class="pull-right">${{ $buyer_order->decimalSubtotal() }}</span>
                            </div>

                            <div class="row">
                                <span class="pull-left">Shipping & Handling:</span>
                                <span class="pull-right">${{ $buyer_order->decimalFee() }}</span>
                            </div>

                            <div class="row">
                                <span class="pull-left">Discount:</span>
                                <span class="pull-right">-${{ $buyer_order->decimalDiscount() }}</span>
                            </div>

                            <div class="row">
                                <span class="pull-left">Total before tax:</span>
                                <span class="pull-right">${{ $buyer_order->decimalSubtotal() - $buyer_order->decimalDiscount() }}</span>
                            </div>

                            <div class="row">
                                <span class="pull-left">Estimated tax to be collected:</span>
                                <span class="pull-right">${{ $buyer_order->decimalTax() }}</span>
                            </div>

                            <div class="row">
                                <span class="pull-left">Total:</span>
                                <span class="pull-right"><strong>${{ $buyer_order->decimalAmount() }}</strong></span>
                            </div>
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
                          {{--  --}}{{-- order details --}}{{--
                            <a class="btn primary-btn btn-block" href="/order/buyer/{{$buyer_order->id}}">Order
                                Details</a>
--}}
                            {{-- cancel order --}}
                            @if ($buyer_order->isCancellable())
                                <a class="btn secondary-btn btn-block cancel-order-btn" href="/order/buyer/cancel/{{ $buyer_order->id }}"
                                   role="button">Cancel Order</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection