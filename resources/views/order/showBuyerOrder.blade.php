@extends('app')

@section('content')
    <head>
        <link href="{{ asset('/css/showBuyerOrder.css') }}" rel="stylesheet" type="text/css">
        <title>Stuvi - Order Details</title>
    </head>

    <!-- print button -->
    <div class="print"><a href="" onclick="printWindow()"><i class="fa fa-print"></i> Print Invoice
        </a>
    </div>

    <!-- flash message -->
    <div class="container" id="message-cont" xmlns="http://www.w3.org/1999/html">
        @if (Session::has('message'))
            <div class="flash-message" id="message">{{ Session::get('message') }}</div>
        @endif
    </div>
    <!-- order details -->
    <div class="container">
        <h1>Order Details</h1>
        <h2>
            <!-- canceled order -->
            @if ($buyer_order->cancelled)<span id="cancelled">This order has been cancelled.</span> @endif
            @if ($buyer_order->pickup_time)
                Delivered @ {{ date($datetime_format, strtotime($buyer_order->pickup_time)) }}
            @endif
        </h2>

        <div class="row" id="details1">
            <p class="col-xs-12 col-sm-3">Ordered on {{ $buyer_order->created_at }}</p>
            <p class="col-xs-12 col-sm-4">Order #{{ $buyer_order->id }}</p>
        </div>
        @if ($buyer_order->deliver_time)
            <p><a class="btn btn-default" href="">Return or replace items</a></p>
        @endif
        @if (!$buyer_order->cancelled)
            <p><a class="btn btn-default btn-cancel" href="/order/buyer/cancel/{{ $buyer_order->id }}">Cancel Order</a></p>
        @endif
    <div class="container" id="details2">
        <div class="row">
            <div class="details-shipping col-xs-12 col-sm-3">
                <?php $shipping_address = $buyer_order->shipping_address ?>
                <h4>Shipping Address</h4>
                <p>{{ $shipping_address->addressee }} <br> {{ $shipping_address->address_line1 }}
                    <br> {{ $shipping_address->city }}, {{ $shipping_address->state_a2 }}  {{ $shipping_address->zip }}</p>
            </div>
            <div class="details-payment col-xs-12 col-sm-3">
                <h4>Payment Method</h4>
                <p>{{ $buyer_order->buyer_payment->card_brand }} **** {{ $buyer_order->buyer_payment->card_last4 }}</p>
            </div>
            <div class="details-pricing col-xs-12 col-sm-3 col-sm-offset-3">
                <h4>Order Summary</h4>
                <p>Total: ${{ $buyer_order->buyer_payment->stripe_amount/100 }}</p>
            </div>
        </div>
    </div>
        <div class="container" id="details3">
            <div class="row row-items">
                <h3 class="col-xs-12">Items</h3>
            </div>
            @foreach ($buyer_order->products() as $product)
                <div class="row">
                    <div class="item col-xs-8">
                        <p>Title: {{ $product->book->title }}</p>
                        <p>ISBN: {{ $product->book->isbn }}</p>
                        <p>Author: @if ($product->book->author) {{ $product->book->author}} @else N/A @endif</p>
                        <?php $seller_order = $buyer_order->seller_order($product->id) ?>
                        <p>Scheduled pickup time:
                            @if ($seller_order->scheduled_pickup_time)
                                {{ date($datetime_format, strtotime($seller_order->scheduled_pickup_time)) }}
                            @else
                                N/A
                            @endif
                        </p>
                        <p>Pickup time:
                            @if ($seller_order->pickup_time)
                                {{ date($datetime_format, strtotime($seller_order->pickup_time)) }}
                            @else
                                N/A
                            @endif
                        </p>

                        @if (!$buyer_order->cancelled && $seller_order->cancelled)
                            <p>NOTE: this product is CANCELLED by the seller.</p>
                        @endif

                    </div>
                    <div class="price col-xs-4">
                        <p><b>${{ $product->price }}</b></p>
                    </div>
                </div>
                <hr>
            @endforeach
        </div>

    </div>

    <!-- print window required -->
    <script src="{{asset('/js/showBuyerOrder.js')}}" type="text/javascript"></script>

@endsection