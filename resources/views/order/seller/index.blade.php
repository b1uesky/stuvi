@extends('layouts.textbook')

@section('title', 'Your Sold books')

@section('content')

    <div class="container">
        <div class="row">
            <ol class="breadcrumb">
                <li><a href="{{ url('textbook') }}">Home</a></li>
                <li class="active">Your sold books</li>
            </ol>
        </div>

        <div class="page-header">
            <h1>Sold books</h1>
        </div>

        @foreach ($seller_orders as $seller_order)
            <div class="panel panel-default">
                <div class="panel-heading">

                    <div class="container-fluid text-muted">
                        <div class="col-xs-4">
                            <div class="row">
                                <span>ORDER SOLD</span>
                            </div>

                            <div class="row">
                                <span>{{ date('M d, Y', strtotime($seller_order->created_at)) }}</span>
                            </div>
                        </div>

                        <div class="col-xs-4">
                            <div class="row">
                                <span>TOTAL</span>
                            </div>

                            <div class="row">
                                <span>${{ $seller_order->product->decimalPrice() }}</span>
                            </div>
                        </div>

                        <div class="col-xs-4 text-right">
                            <div class="row">
                                <span>ORDER #{{ $seller_order->id }}</span>
                            </div>

                            <div class="row">
                                <span><a href="/order/seller/{{$seller_order->id}}">View Details</a></span>
                            </div>
                        </div>
                    </div>
                </div>

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
                                        <?php $product = $seller_order->product; ?>

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
                                            <div class="container-fluid">
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
                                    <br>
                            </div>

                            {{-- action buttons --}}
                            <div class="col-md-3">
                                @if ($seller_order->isPickupConfirmable())
                                    <a class="btn btn-primary btn-block" href="{{ url('order/seller/' . $seller_order->id . '/schedulePickup') }}">Update Pickup Details</a>
                                @endif

                                {{-- cancel order --}}
                                @if ($seller_order->isCancellable())
                                    <a class="btn btn-danger btn-block" href="#cancel-seller-order" data-toggle="modal" data-seller_order_id="{{ $seller_order->id }}">Cancel Order</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{--<p>You haven't sold any books. Why not <a href="{{ url('/textbook/sell') }}">sell some</a>?</p>--}}

    </div>

    @include('includes.modal.cancel-seller-order')
@endsection

@section('javascript')
    <script src="{{ asset('js/order/seller/index.js') }}"></script>
@endsection