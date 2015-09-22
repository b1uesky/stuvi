@extends('layouts.express')

@section('title', 'Pickup')

@section('content')


        {{-- New/Todo/Picked Up switch buttons --}}
        <div class="btn-group btn-group-justified" role="group">
            <a href="{{ url('express/pickup') }}" role="button" class="btn btn-default {{ Request::is('express/pickup') ? 'active' : '' }}">New</a>
            <a href="{{ url('express/pickup/todo') }}" role="button" class="btn btn-default {{ Request::segment(3) == 'todo' ? 'active' : '' }}">Todo</a>
            <a href="{{ url('express/pickup/pickedUp') }}" role="button" class="btn btn-default {{ Request::segment(3) == 'pickedUp' ? 'active' : '' }}">Picked Up</a>
        </div>

        <br>

        {{-- A list of scheduled seller orders --}}
        @if (!empty($seller_orders))
            <div class="list-group">
                @foreach($seller_orders as $seller_order)
                    <a href="{{ url('express/pickup/' . $seller_order->id) }}" class="list-group-item">
                        <h4 class="list-group-item-heading">Order #{{ $seller_order->id }}: {{ $seller_order->book()->title }}</h4>
                        <p class="list-group-item-text">Scheduled Pickup: {{ $seller_order->scheduled_pickup_time }}</p>
                    </a>
                @endforeach
            </div>
        @endif

@endsection
