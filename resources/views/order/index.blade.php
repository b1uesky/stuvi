@extends('app')

@section('content')
    <div class="container">

        @forelse ($orders as $order)
            <div class="row">
            <li>Order #{{ $order->id }}</li>
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