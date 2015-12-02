<!-- http://homestead.app/order/buyer -->

@extends('layouts.textbook')

@section('title', 'Your orders')

@section('content')

    <div class="container">
        <div class="row">
            <ol class="breadcrumb">
                <li><a href="{{ url('/') }}">Home</a></li>
                <li class="active">Your orders</li>
            </ol>
        </div>

        <div class="page-header">
            <h1>Your orders</h1>
        </div>

        {{-- order list --}}
        @foreach ($buyer_orders as $buyer_order)
            <div class="panel panel-default">
                <div class="panel-heading">

                    {{-- order details --}}
                    <div class="container-fluid text-muted">
                        <div class="col-xs-4">
                            <div class="row">
                                <span>ORDER PLACED</span>
                            </div>

                            <div class="row">
                                <span>{{ date('M d, Y', strtotime($buyer_order->created_at)) }}</span>
                            </div>
                        </div>

                        <div class="col-xs-4">
                            @if(!$buyer_order->cancelled)
                                <div class="row">
                                    <span>TOTAL</span>
                                </div>

                                <div class="row">
                                    <span>${{ $buyer_order->decimalAmount() }}</span>
                                </div>
                            @endif
                        </div>

                        <div class="col-xs-4 text-right">
                            <div class="row">
                                <span>ORDER #{{ $buyer_order->id }}</span>
                            </div>

                            <div class="row">
                                <span><a href="/order/buyer/{{$buyer_order->id}}">View details</a></span>
                            </div>
                        </div>
                    </div>
                </div>

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

                                    @include('includes.textbook.product-details')
                                    <br>
                                @endforeach
                            </div>

                            {{-- action buttons --}}
                            <div class="col-md-3">
                                @if($buyer_order->isDeliverySchedulable())
                                    <a class="btn btn-primary btn-block" href="{{ url('order/buyer/' . $buyer_order->id . '/scheduleDelivery') }}">Update delivery details</a>
                                @endif

                                {{-- cancel order --}}
                                @if($buyer_order->isCancellable())
                                    <button type="button" class="btn btn-danger btn-block" data-toggle="modal"
                                            data-target="#cancel-buyer-order"
                                            data-buyer-order-id="{{ $buyer_order->id }}">Cancel order</button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection

@include('includes.modal.cancel-buyer-order')