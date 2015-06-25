@extends('express')

@section('content')
    <div class="container">
        {{-- Error --}}
        @if (Session::has('error'))
            <div class="alert alert-danger">
                {{ Session::get('error') }}
            </div>
        @endif

        {{-- A list of buyer orders --}}
        @if (!empty($buyer_orders))
            <div class="list-group">
                @foreach($buyer_orders as $buyer_order)
                    <a href="{{ URL::to('express/deliver/' . $buyer_order->id) }}" class="list-group-item">
                        @foreach($buyer_order->products() as $product)
                            <h4 class="list-group-item-heading">{{ $product->book->title }}</h4>
                        @endforeach
                    </a>
                @endforeach
            </div>
        @endif
    </div>
@endsection