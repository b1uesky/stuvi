@extends('layouts.express')

@section('title', 'Pickup')

@section('content')


    {{-- New/Picked Up switch buttons --}}
    <div class="btn-group btn-group-justified" role="group">
        <a href="{{ url('express/pickup') }}" role="button" class="btn btn-default">New</a>
        <a href="{{ url('express/pickup/todo') }}" role="button" class="btn btn-default">Todo</a>
        <a href="{{ url('express/pickup/pickedUp') }}" role="button" class="btn btn-default">Picked Up</a>
    </div>

    <br>

    {{-- Donation Details --}}
    <div class="list-group">
        {{-- Donation Number --}}
        <li class="list-group-item">
            <h4 class="list-group-item-heading">Donation Number</h4>
            <p class="list-group-item-text">{{ $donation->id }}</p>
        </li>

        {{-- Quantity --}}
        <li class="list-group-item">
            <h4 class="list-group-item-heading">Quantity</h4>
            <p class="list-group-item-text">{{ $donation->quantity }}</p>
        </li>

        {{-- Scheduled Pickup Time --}}
        <li class="list-group-item">
            <h4 class="list-group-item-heading">Scheduled Pickup Time</h4>
            <p class="list-group-item-text">{{ $donation->scheduled_pickup_time }}</p>
        </li>

        {{-- Address --}}
        <li class="list-group-item">
            <h4 class="list-group-item-heading">Address</h4>
            <p class="list-group-item-text">
                {{ $donation->address->addressee }}
            </p>
            <p class="list-group-item-text">
                {{ $donation->address->address_line1 }},
                {{ $donation->address->address_line2 }}
            </p>
            <p class="list-group-item-text">
                {{ $donation->address->city }},
                {{ $donation->address->state_a2 }}
                {{ $donation->address->zip }}
            </p>
        </li>

        {{-- Phone Number --}}
        <li class="list-group-item">
            <h4 class="list-group-item-heading">Phone Number</h4>
            <p class="list-group-item-text">
                {{ $donation->address->phone_number }}
            </p>
        </li>

    </div>

    {{-- Ready to pick up --}}
    @if(!$donation->courier_id && !$donation->pickup_time)
        <a href="{{ url('express/pickup/donation/'. $donation->id . '/readyToPickUp') }}" class="btn btn-primary btn-lg btn-block">
            Ready to pick up
        </a>
        {{-- Verification Code --}}
    @elseif(!$donation->pickup_time)
        <form action="{{ url('express/pickup/donation/' . $donation->id . '/confirm') }}" method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="form-group">
                By confirming the pickup, you agree to Stuvi's <a href="{{url('/tos')}}" target="_blank" > Terms of Service</a>
                and <a href="{{url('/privacy')}}" target="_blank"> Privacy Notice</a>.
            </div>

            <div class="form-group">
                <input type="number" class="form-control input-lg" name="pickup_code" placeholder="Enter the 4-digit verification code" required/>
            </div>

            <button type="submit" class="btn btn-primary btn-lg btn-block">Confirm Pickup</button>
        </form>
    @else
        <div class="alert alert-success" role="alert">The textbook has been picked up.</div>
    @endif

    <br>

@endsection
