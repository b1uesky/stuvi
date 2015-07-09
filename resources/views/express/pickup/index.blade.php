@extends('express')

@section('title', 'Pickup')

@section('content')
    <div class="container">
        {{-- Error --}}
        @if (Session::has('error'))
            <div class="alert alert-danger">
                {{ Session::get('error') }}
            </div>
        @endif

        {{-- New/Todo/Picked Up switch buttons --}}
        <div class="btn-group btn-group-justified" role="group">
            <a href="{{ URL::to('express/pickup') }}" role="button" class="btn btn-default">New</a>
            <a href="{{ URL::to('express/pickup/todo') }}" role="button" class="btn btn-default">Todo</a>
            <a href="{{ URL::to('express/pickup/pickedUp') }}" role="button" class="btn btn-default">Picked Up</a>
        </div>

        {{-- A list of scheduled seller orders --}}
        @if (!empty($seller_orders))
            <div class="list-group">
                @foreach($seller_orders as $seller_order)
                    <a href="{{ URL::to('express/pickup/' . $seller_order->id) }}" class="list-group-item">
                        <h4 class="list-group-item-heading">Order #{{ $seller_order->id }}: {{ $seller_order->book()->title }}</h4>
                        <p class="list-group-item-text">Scheduled Pickup: {{ $seller_order->scheduled_pickup_time }}</p>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
@endsection