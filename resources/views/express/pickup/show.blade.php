@extends('express')

@section('content')
    <div class="container">
        {{-- Errors --}}
        @if($errors->has())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    {{ $error }}<br>
                @endforeach
            </div>
        @endif

        {{-- Seller Order Details --}}
        <div class="list-group">
            <li class="list-group-item">
                <h4 class="list-group-item-heading">{{ $seller_order->book()->title }}</h4>
                <div class="media">
                    <img class="img-responsive" src="{{ $seller_order->book()->imageSet->large_image }}" alt=""/>
                </div>
            </li>
            <li class="list-group-item">
                <h4 class="list-group-item-heading">Scheduled Pickup Time</h4>
                <p class="list-group-item-text">{{ $seller_order->scheduled_pickup_time }}</p>
            </li>
            <li class="list-group-item">
                <h4 class="list-group-item-heading">Address</h4>
                <p class="list-group-item-text">
                    {{ $seller_order->address->addressee }}
                </p>
                <p class="list-group-item-text">
                    {{ $seller_order->address->address_line1 }},
                    {{ $seller_order->address->address_line2 }}
                </p>
                <p class="list-group-item-text">
                    {{ $seller_order->address->city }},
                    {{ $seller_order->address->state_a2 }}
                    {{ $seller_order->address->zip }}
                </p>
            </li>
            <li class="list-group-item">
                <h4 class="list-group-item-heading">Phone Number</h4>
                <p class="list-group-item-text">
                    {{ $seller_order->address->phone_number }}
                </p>
            </li>
        </div>

        {{-- Verification Code --}}
        @if(!$seller_order->pickedUp())
            <form action="{{ URL::to('express/pickup/' . $seller_order->id . '/confirm') }}" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group">
                    <input type="number" class="form-control input-lg" name="code" placeholder="Enter the 4-digit verification code"/>
                </div>

                <button type="submit" class="btn btn-warning btn-lg btn-block">Confirm Pickup</button>
            </form>
        @else
            <div class="alert alert-success" role="alert">Well Done! The textbook has been picked up.</div>
        @endif

    </div>
@endsection