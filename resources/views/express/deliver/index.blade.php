@extends('layouts.express')

@section('title', 'Deliver')

@section('content')

        {{-- New/Todo/Delivered switch buttons --}}
        <div class="btn-group btn-group-justified" role="group">
            <a href="{{ url('express/deliver') }}" role="button" class="btn btn-default">New</a>
            <a href="{{ url('express/deliver/todo') }}" role="button" class="btn btn-default">Todo</a>
            <a href="{{ url('express/deliver/delivered') }}" role="button" class="btn btn-default">Delivered</a>
        </div>

        <br>

        {{-- A list of buyer orders --}}
        @if (!empty($buyer_orders))
            <div class="list-group">
                @foreach($buyer_orders as $buyer_order)
                    @if(count($buyer_order->products()) > 0)
                        <a href="{{ url('express/deliver/' . $buyer_order->id) }}" class="list-group-item">
                            <h4 class="list-group-item-heading">Order #{{ $buyer_order->id }}</h4>
                            <p class="list-group-item-text">{{ \App\Helpers\DateTime::showDatetime($buyer_order->scheduled_delivery_time) }}</p>

                            @foreach($buyer_order->products() as $p_index => $product)
                                <p class="list-group-item-text">{{ $p_index + 1 }}. {{ $product->book->title }}</p>
                            @endforeach
                        </a>
                    @endif
                @endforeach
            </div>
        @endif
@endsection
