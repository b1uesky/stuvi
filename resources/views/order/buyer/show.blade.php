@extends('app')

@section('title', 'Order #'.$buyer_order->id)

@section('css')
    <link href="{{ asset('/css/order_show.css') }}" rel="stylesheet">
@endsection

@section('content')

    @include('includes.textbook.flash-message')

    <!-- order details -->
    <div class="container">
        {!! Breadcrumbs::render() !!}

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
            <p><a class="btn btn-default secondary-btn" href="/order/buyer/cancel/{{ $buyer_order->id }}">Cancel
                    Order</a></p>
        @endif
        <div class="container box" id="details2">
            <div class="row row-title">
                <div class="details-shipping col-xs-12 col-sm-3">
                    <?php $shipping_address = $buyer_order->shipping_address ?>
                    <h4>Shipping Address</h4>

                    <p>{{ $shipping_address->addressee }} <br> {{ $shipping_address->address_line1 }}
                        <br> {{ $shipping_address->city }}
                        , {{ $shipping_address->state_a2 }}  {{ $shipping_address->zip }}</p>
                </div>
                <div class="details-payment col-xs-12 col-sm-3">
                    <h4>Payment Method</h4>

                    {{--<p>{{ ucfirst($buyer_order->buyer_payment->card_brand) }}--}}
                        {{--**** {{ $buyer_order->buyer_payment->card_last4 }}</p>--}}
                </div>
                <div class="details-pricing col-xs-12 col-sm-3 col-sm-offset-3">
                    <h4>Order Summary</h4>
                    <p>Fee: ${{ $buyer_order->fee/100 }}<br>
                        Discount: - ${{ $buyer_order->discount/100 }}<br>
                        Tax: ${{ $buyer_order->tax/100 }}<br>
                        Total: ${{ $buyer_order->amount/100 }}</p>
                </div>
            </div>
            <div class="buyer-items">
                @foreach ($buyer_order->seller_orders as $seller_order)
                    <?php $product = $seller_order->product ?>
                    <div class="row">
                        <div class="col-sm-2">
                            @if($product->book->imageSet->large_image)
                                <img class="lg-img" src="{{ config('aws.url.stuvi-book-img') . $product->book->imageSet->large_image}}">
                            @else
                                <img class="lg-img" src="{{ config('book.default_image_path.large') }}">
                            @endif
                        </div>
                        <div class="item col-sm-7">
                            <p>Title: {{ $product->book->title }}</p>

                            <p>ISBN: {{ $product->book->isbn13 }}</p>

                            <p><span>Author(s): </span>
                            @foreach($product->book->authors as $author)
                                <span>{{ $author->full_name }}</span>
                            @endforeach
                            </p>

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
                        <div class="price col-sm-3">
                            <p><b>${{ $product->decimalPrice() }}</b></p>
                        </div>
                    </div>
                </div>
                <hr>
            @endforeach
        </div>
    </div>

@endsection

@section('javascript')
    <script>
        function goBack() {
            window.history.back();
        }
    </script>
@endsection