@extends('app')

@section('content')
    <div class="container" xmlns="http://www.w3.org/1999/html">
        @if (Session::has('message'))
            <div class="flash-message">{{ Session::get('message') }}</div>
        @endif
    </div>
    <div class="container">
        <h1>Order #{{ $buyer_order->id }}</h1> <a href="">Return or replace items</a>
        <p>{{ $buyer_order->created_at }}</p>
        <?php $shipping_address = $buyer_order->shipping_address ?>
        <p>To {{ $shipping_address->addressee }} @ {{ $shipping_address->address_line1 }}  {{ $shipping_address->city }}, {{ $shipping_address->state_a2 }}  {{ $shipping_address->zip }}</p>

        <div class="container">
            <?php $products = $buyer_orders->products ?>
            @foreach ($products as $product)
                <div class="row">

                </div>
            @endforeach
        </div>

    </div>

@endsection