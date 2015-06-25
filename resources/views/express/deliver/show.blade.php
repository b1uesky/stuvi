@extends('express')

@section('content')
    <div class="container">
        {{-- Errors --}}
        @if($errors->has())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    {{ $error }}<br>
                @endforeach
            </div>
        @endif

        {{-- Buyer Order Details --}}
        <div class="list-group">
            {{-- A list of books --}}
            @foreach($buyer_order->products() as $index => $product)
                    <li class="list-group-item">
                        <h4 class="list-group-item-heading">#{{ $index+1 }}: {{ $product->book->title }}</h4>
                        <div class="media">
                            <img class="img-responsive" src="{{ $product->book->imageSet->medium_image }}" alt=""/>
                        </div>
                    </li>
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
    </div>
@endsection