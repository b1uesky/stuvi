@extends('layouts.textbook')

@section('title', 'Your Sold books')

@section('content')

    <div class="container">
        <div class="row">
            <ol class="breadcrumb">
                <li><a href="{{ url('/') }}">Home</a></li>
                <li class="active">Your sold books</li>
            </ol>
        </div>

        <div class="page-header">
            <h1>Sold books</h1>
        </div>

        @foreach ($seller_orders as $seller_order)
            @if($seller_order->buyer_order_id)
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
                                <span>${{ $seller_order->product->price }}</span>
                            </div>
                        </div>

                        <div class="col-xs-4 text-right">
                            <div class="row">
                                <span>ORDER #{{ $seller_order->id }}</span>
                            </div>

                            <div class="row">
                                <span><a href="/order/seller/{{$seller_order->id}}">View details</a></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel-body">
                    <div class="container-fluid">
                        {{-- order status --}}
                        <div class="row">
                            <?php $order_status = $seller_order->getOrderStatus(); ?>

                            <h3>{{ $order_status['status'] }}</h3>
                            <span>{{ $order_status['detail'] }}</span>
                        </div>

                        <br>

                        <div class="row">
                            <div class="col-md-9">
                                <!-- product list -->
                                    <div class="row">
                                        <?php $product = $seller_order->product; ?>

                                        @include('includes.textbook.product-details')
                                    </div>
                                    <br>
                            </div>

                            {{-- action buttons --}}
                            <div class="col-md-3">
                                @if ($seller_order->isPickupSchedulable())
                                    <a class="btn btn-primary btn-block" href="{{ url('order/seller/' . $seller_order->id . '/schedulePickup') }}">Update pickup details</a>
                                @endif

                                {{-- cancel order --}}
                                @if ($seller_order->isCancellable())
                                    <a class="btn btn-default btn-block" href="#cancel-seller-order" data-toggle="modal" data-seller_order_id="{{ $seller_order->id }}">Cancel order</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @else
                <div class="panel panel-info">
                    <div class="panel-heading">

                        <div class="container-fluid text-muted">
                            <div class="col-xs-4">
                                <div class="row">
                                    <span>TRADE-IN APPROVED</span>
                                </div>

                                <div class="row">
                                    <span>{{ date('M d, Y', strtotime($seller_order->created_at)) }}</span>
                                </div>
                            </div>

                            <div class="col-xs-4">
                                <div class="row">
                                    <span>TRADE-IN PRICE</span>
                                </div>

                                <div class="row">
                                    <span>${{ $seller_order->product->trade_in_price }}</span>
                                </div>
                            </div>

                            <div class="col-xs-4 text-right">
                                <div class="row">
                                    <span>ORDER #{{ $seller_order->id }}</span>
                                </div>

                                <div class="row">
                                    <span><a href="/order/seller/{{$seller_order->id}}">View details</a></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel-body">
                        <div class="container-fluid">
                            {{-- order status --}}
                            <div class="row">
                                <?php $order_status = $seller_order->getOrderStatus(); ?>

                                <h3>{{ $order_status['status'] }}</h3>
                                <span>{{ $order_status['detail'] }}</span>
                            </div>

                            <br>

                            <div class="row">
                                <div class="col-md-9">
                                    <!-- product list -->
                                    <div class="row">
                                        <?php $product = $seller_order->product; ?>

                                        @include('includes.textbook.product-details')
                                    </div>
                                    <br>
                                </div>

                                {{-- action buttons --}}
                                <div class="col-md-3">
                                    @if ($seller_order->isPickupSchedulable())
                                        <a class="btn btn-primary btn-block" href="{{ url('order/seller/' . $seller_order->id . '/schedulePickup') }}">Update pickup details</a>
                                    @endif

                                    {{-- cancel order --}}
                                    @if ($seller_order->isCancellable())
                                        <form action="{{ url('order/seller/cancelTradeIn') }}" method="post" class="margin-top-5">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="seller_order_id" value="{{ $seller_order->id }}">

                                            <button type="submit" class="btn btn-default btn-block">Not interested</button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>

    {{--<p>You haven't sold any books. Why not <a href="{{ url('/textbook/sell') }}">sell some</a>?</p>--}}

    </div>

    @include('includes.modal.cancel-seller-order')
@endsection