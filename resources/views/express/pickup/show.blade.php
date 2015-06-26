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

        {{-- New/Picked Up switch buttons --}}
        <div class="btn-group btn-group-justified" role="group">
            <a href="{{ URL::to('express/pickup') }}" role="button" class="btn btn-default">New</a>
            <a href="{{ URL::to('express/pickup/todo') }}" role="button" class="btn btn-default">Todo</a>
            <a href="{{ URL::to('express/pickup/pickedUp') }}" role="button" class="btn btn-default">Picked Up</a>
        </div>

        {{-- Seller Order Details --}}
        <div class="list-group">
            {{-- Book Info --}}
            <li class="list-group-item">
                <h4 class="list-group-item-heading">{{ $seller_order->book()->title }}</h4>
                <div class="media">
                    <img class="img-responsive" src="{{ $seller_order->book()->imageSet->large_image }}" alt=""/>
                </div>
            </li>

            {{-- Scheduled Pickup Time --}}
            <li class="list-group-item">
                <h4 class="list-group-item-heading">Scheduled Pickup Time</h4>
                <p class="list-group-item-text">{{ $seller_order->scheduled_pickup_time }}</p>
            </li>

            {{-- Address --}}
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

            {{-- Phone Number --}}
            <li class="list-group-item">
                <h4 class="list-group-item-heading">Phone Number</h4>
                <p class="list-group-item-text">
                    {{ $seller_order->address->phone_number }}
                </p>
            </li>
        </div>

        {{-- Ready to pick up --}}
        @if(!$seller_order->assignedToCourier())
            <a href="{{ URL::to('express/pickup/'. $seller_order->id . '/readyToPickUp') }}" class="btn btn-primary btn-lg btn-block">
                Ready to pick up
            </a>
        {{-- Verification Code --}}
        @elseif(!$seller_order->pickedUp())
            <form action="{{ URL::to('express/pickup/' . $seller_order->id . '/confirm') }}" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group">
                    <input type="number" class="form-control input-lg" name="code" placeholder="Enter the 4-digit verification code"/>
                </div>

                <button type="submit" class="btn btn-warning btn-lg btn-block">Confirm Pickup</button>
            </form>
        @else
            <div class="alert alert-success" role="alert">The textbook has been picked up.</div>
        @endif

    </div>
@endsection