{{-- Your orders page --}}

@extends('layouts.textbook')

@section('title', 'Order details - Order #'.$seller_order->id)

@section('content')
    <div class="container">
        <div class="row">
            <ol class="breadcrumb">
                <li><a href="{{ url('textbook') }}">Home</a></li>
                <li><a href="{{ url('order/seller') }}">Your sold books</a></li>
                <li class="active">Order #{{ $seller_order->id }}</li>
            </ol>
        </div>

        <div class="page-header">
            <h1>Order Details</h1>
        </div>

        @if ($seller_order->isDelivered()
        && empty($seller_order->payout_item_id)
        && empty($seller_order->seller()->profile->paypal))
            <div class="alert alert-warning" role="alert">
                Please fill in your Paypal account in <a href="{{ url('user/profile') }}"><strong>profile</strong></a> to transfer your balance.
            </div>
        @endif


        <div class="panel panel-default">
            <div class="panel-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-5">
                            <span>Sold on {{ $seller_order->created_at }}</span>
                        </div>
                        <div class="col-sm-5">
                            @if($seller_order->cancelled)
                                <span>Cancelled at {{ $seller_order->cancelled_time }}</span>
                            @endif
                        </div>
                        <div class="col-sm-2">
                            <span>Order #{{ $seller_order->id }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- item --}}
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="container-fluid">
                    {{-- order status --}}
                    <div class="row">
                        <?php $order_status = $seller_order->getOrderStatus(); ?>

                        @if(!$seller_order->cancelled)
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="{{ $order_status['value'] }}" aria-valuemin="0" aria-valuemax="100" style="{{ 'width: ' . $order_status['value'] . '%;' }}">
                                    <span class="sr-only">{{ $order_status['value'] }}% Complete</span>
                                </div>
                            </div>
                        @endif

                        <h3>{{ $order_status['status'] }}</h3>
                        <span>{{ $order_status['detail'] }}</span>
                    </div>

                    <br>

                    <div class="row">
                        <div class="col-md-9">
                            <!-- product list -->
                            <div class="row">
                                <?php $product = $seller_order->product;?>

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
                                <div class="col-md-10 book-details-row">
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
                        </div>

                        {{-- action buttons --}}
                        <div class="col-md-3">
                            @if ($seller_order->isPickupConfirmable())
                                <a class="btn btn-primary btn-block" href="{{ url('order/seller/' . $seller_order->id . '/schedulePickup') }}">Update Pickup Details</a>
                            @endif

                            {{-- cancel order --}}
                            @if ($seller_order->isCancellable())
                                <a class="btn btn-danger btn-block cancel-order-btn" href="/order/seller/cancel/{{ $seller_order->id }}"
                                   role="button">Cancel Order</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- balance --}}
        @if ($seller_order->isDelivered())
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="container-fluid">
                    <div class="row">
                        <h3>Balance</h3>
                    </div>

                    <br>

                    <div class="row">
                    @if ($seller_order->payout_item_id)
                        <p>Payout Item ID: {{ $seller_order->payout_item_id}}</p>
                    @else
                        <form action="{{url('/order/seller/'.$seller_order->seller()->id.'/payout')}}" method="POST" class="form-horizontal">
                            {!! csrf_field() !!}
                            <input type="hidden" name="seller_order_id" value="{{ $seller_order->id }}">

                            <div class="form-group">
                                <div class=" col-sm-6">
                                    <button id="save-info-btn" type="submit" class="btn btn-primary">Transfer balance to my Paypal account
                                    </button>
                                </div>
                            </div>
                        </form>
                    @endif
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
@endsection
