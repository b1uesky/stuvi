@extends('layouts.textbook')

@section('title', 'Schedule a pickup')

@section('content')

    <div class="container">

        <div class="row">
            <div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">

                <div class="page-header">
                    <h1>Schedule pickup</h1>
                </div>

                @include('includes.textbook.pickup-address')
                @include('includes.textbook.pickup-time')

                <br>

                <form action="{{ url('/order/seller/' . $seller_order->id . '/confirmPickup') }}" method="post" id="form-confirm-pickup">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    {{-- Check if it's a trade-in --}}
                    <input type="hidden" name="is_trade_in" value="{{ $seller_order->buyer_order_id ? false : true }}">

                    <?php $address = Auth::user()->defaultAddress(); ?>
                    <input type="hidden" name="address_id" value="{{ $address ? $address->id : '' }}">

                    @if($seller_order->scheduled_pickup_time)
                        <input type="hidden" name="scheduled_pickup_time" value="{{ \App\Helpers\DateTime::showDatetime($seller_order->scheduled_pickup_time) }}">
                    @else
                        <input type="hidden" name="scheduled_pickup_time">
                    @endif

                    <input type="submit" class="btn btn-primary" value="Update pickup details">
                </form>

                    <br>
            </div>
        </div>
    </div>
@endsection