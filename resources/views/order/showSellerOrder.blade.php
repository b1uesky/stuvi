@extends('app')

@section('content')
    <div class="container" xmlns="http://www.w3.org/1999/html">
        @if (Session::has('message'))
            <div class="flash-message">{{ Session::get('message') }}</div>
        @endif
    </div>
    <div class="container">
        <h1>Order #{{ $seller_order->id }} @if ($seller_order->cancelled) (CANCELLED) @endif</h1>
        @if (!$seller_order->cancelled)
            <p><a href="/order/cancel/{{ $seller_order->id }}">Cancel Order</a></p>
        @endif

        <p>{{ $seller_order->created_at }}</p>

        <div class="container">
            <div class="row">
                {{ var_dump($seller_order->product()) }}
            </div>
        </div>

    </div>

@endsection