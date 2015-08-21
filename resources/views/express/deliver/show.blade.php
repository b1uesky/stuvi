@extends('express')

@section('title', 'Deliver')

@section('content')
    <div class="container">

        {{-- New/Todo/Delivered switch buttons --}}
        <div class="btn-group btn-group-justified" role="group">
            <a href="{{ URL::to('express/deliver') }}" role="button" class="btn btn-default">New</a>
            <a href="{{ URL::to('express/deliver/todo') }}" role="button" class="btn btn-default">Todo</a>
            <a href="{{ URL::to('express/deliver/delivered') }}" role="button" class="btn btn-default">Delivered</a>
        </div>

        {{-- Buyer Order Details --}}
        <div class="list-group">
            {{-- Order Number --}}
            <li class="list-group-item">
                <h4 class="list-group-item-heading">Order Number</h4>
                <p class="list-group-item-text">{{ $buyer_order->id }}</p>
            </li>

            {{-- A list of books --}}
            @foreach($buyer_order->seller_orders as $seller_order)
                {{-- check if this product is picked up --}}
                @if ($seller_order->pickedUp())
                    <li class="list-group-item">
                        <h4 class="list-group-item-heading">{{ $seller_order->product->book->title }}</h4>
                        <div class="media">
                            @if($seller_order->book()->imageSet->large_image)
                                <img class="img-responsive" src="{{ config('aws.url.stuvi-book-img') . $seller_order->book()->imageSet->large_image }}" alt=""/>
                            @else
                                <img class="img-responsive" src="{{ config('book.default_image_path.large') }}" alt=""/>
                            @endif
                        </div>
                    </li>
                @endif
            @endforeach

            {{-- Address --}}
            <li class="list-group-item">
                <h4 class="list-group-item-heading">Address</h4>
                <p class="list-group-item-text">
                    {{ $buyer_order->shipping_address->addressee }}
                </p>
                <p class="list-group-item-text">
                    {{ $buyer_order->shipping_address->address_line1 }},
                    {{ $buyer_order->shipping_address->address_line2 }}
                </p>
                <p class="list-group-item-text">
                    {{ $buyer_order->shipping_address->city }},
                    {{ $buyer_order->shipping_address->state_a2 }}
                    {{ $buyer_order->shipping_address->zip }}
                </p>
            </li>

            {{-- Phone Number --}}
            <li class="list-group-item">
                <h4 class="list-group-item-heading">Phone Number</h4>
                <p class="list-group-item-text">
                    {{ $buyer_order->shipping_address->phone_number }}
                </p>
            </li>
        </div>

        {{-- Show Ready to ship button if the order is not yet assigned --}}
        @if(!$buyer_order->assignedToCourier())
            <a href="{{ URL::to('express/deliver/' . $buyer_order->id . '/readyToShip') }}" class="btn btn-primary btn-lg btn-block">Ready to ship!</a>
        @elseif(!$buyer_order->isDelivered())
            {{-- Show Confirm Delivery button --}}
            <a href="{{ URL::to('express/deliver/' . $buyer_order->id . '/confirmDelivery') }}" class="btn btn-warning btn-lg btn-block">Confirm Delivery</a>
        @else
            {{-- The order has been delivered --}}
            <div class="alert alert-success" role="alert">The textbook has been delivered.</div>
        @endif
    </div>
@endsection