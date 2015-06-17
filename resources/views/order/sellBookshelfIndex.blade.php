p@extends('app')

@section('content')
    <div class="container" xmlns="http://www.w3.org/1999/html">
        @if (Session::has('message'))
            <div class="flash-message">{{ Session::get('message') }}</div>
        @endif
    </div>
    <div class="container">
        <h1>Your buyer orders:</h1>
        @forelse ($orders as $order)
            <div class="row">
            <li><a href="{{ url('order/buyer/'.$order->id) }}">Order #{{ $order->id }}</a></li>
                {{--
            <li>{{ $order->buyer_payment()->stripe_amount/100 }}</li>
            <p>Product info:</p><br>
            <li>{{ $order->product->book->title }}</li>
            <li>{{ $order->product->book->isbn }}</li>
            <li>{{ $order->product->book->author }}</li>
            --}}
            --------------------------------------------------------------<br>
            </div>
        @empty
            <p>You don't have any orders.</p>
        @endforelse

    </div>
@endsection