@extends('express')

@section('content')
    <div class="container">
        <div class="list-group">
            <li class="list-group-item">
                <h4 class="list-group-item-heading">Book Title</h4>
                <p class="list-group-item-text">{{ $seller_order->book()->title }}</p>
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
    </div>
@endsection