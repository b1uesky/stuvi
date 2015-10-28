@extends('layouts.textbook')

@section('title', 'Schedule a delivery')

@section('content')

    <div class="container">

        <div class="row">
            <div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">

                <div class="page-header">
                    <h1>Schedule delivery</h1>
                </div>

                @include('includes.textbook.delivery-address')
                @include('includes.textbook.delivery-time')

                <br>

                <form action="{{ url('/order/buyer/' . $buyer_order->id . '/confirmDelivery') }}" method="post">
                    {!! csrf_field() !!}

                    <?php $address = Auth::user()->defaultAddress(); ?>
                    <input type="hidden" name="address_id" value="{{ $address ? $address->id : '' }}">

                    @if($buyer_order->scheduled_delivery_time)
                        <input type="hidden" name="scheduled_delivery_time" value="{{ \App\Helpers\DateTime::showDatetime($buyer_order->scheduled_delivery_time) }}">
                    @else
                        <input type="hidden" name="scheduled_delivery_time">
                    @endif

                    <input type="submit" class="btn btn-primary" value="Update delivery details">
                </form>

                <br>
            </div>
        </div>
    </div>
@endsection