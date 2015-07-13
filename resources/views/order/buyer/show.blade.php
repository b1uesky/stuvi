@extends('app')

@section('title', 'Order #'.$buyer_order->id)

@section('css')
    <link href="{{ asset('/css/order/showOrder.css') }}" rel="stylesheet">
@endsection

@section('content')

    <!-- flash message -->
    <div class="container" id="message-cont" xmlns="http://www.w3.org/1999/html">
        @if (Session::has('message'))
            <div class="flash-message" id="message">{{ Session::get('message') }}</div>
        @endif
    </div>
    <!-- order details -->
    <div class="container">
        <h1 id="">Order Details</h1>
        <h2>
            <!-- canceled order -->
            @if ($buyer_order->cancelled)<span id="cancelled">This order has been cancelled.</span> @endif
        </h2>

        <div class="row" id="details1">
            <p class="col-xs-12 col-sm-3">Ordered on {{ $buyer_order->created_at }}</p>
            <p class="col-xs-12 col-sm-4">Order #{{ $buyer_order->id }}</p>
        </div>
        <div class="row" id="details1">
            @if ($buyer_order->isDelivered())
                <p class="col-xs-12 col-sm-3">Delivered on {{ date($datetime_format, strtotime($buyer_order->time_delivered)) }}</p>
            @endif
        </div>
        @if ($buyer_order->isCancellable())
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
                <p>Total: ${{ $buyer_order->buyer_payment->amount/100 }}</p>
            </div>
        </div>
    </div>
        <div class="container" id="details3">
            <div class="row row-items">
                <h3 class="col-xs-12">Items</h3>
            </div>
            @foreach ($buyer_order->seller_orders as $seller_order)
                <?php $product = $seller_order->product ?>
                <div class="row">
                    <div class="item col-xs-8">
                        <p>Title: {{ $product->book->title }}</p>

                        <p>ISBN: {{ $product->book->isbn13 }}</p>
                        <span>Author(s): </span>
                        @foreach($product->book->authors as $author)
                            <span>{{ $author->full_name }}</span>
                        @endforeach
                        <br>
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
                    <div class="price col-xs-3 col-xs-offset-1">
                        <p><b>${{ $product->price }}</b></p>
                    </div>
                </div>
                <hr>
            @endforeach
        </div>

    </div>

@endsection

@section('javascript')
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
    <!-- print window required -->
    <script src="{{asset('/js/showOrder.js')}}" type="text/javascript"></script>
@endsection