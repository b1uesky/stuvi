@extends('express')

@section('content')
    <div class="container">
        {{-- Error --}}
        @if (Session::has('error'))
            <div class="alert alert-danger">
                {{ Session::get('error') }}
            </div>
        @endif

        {{-- New/Todo/Delivered switch buttons --}}
        <div class="btn-group btn-group-justified" role="group">
            <a href="{{ URL::to('express/deliver') }}" role="button" class="btn btn-default">New</a>
            <a href="{{ URL::to('express/deliver/todo') }}" role="button" class="btn btn-default">Todo</a>
            <a href="{{ URL::to('express/deliver/delivered') }}" role="button" class="btn btn-default">Delivered</a>
        </div>

        {{-- A list of buyer orders --}}
        @if (!empty($buyer_orders))
            <div class="list-group">
                @foreach($buyer_orders as $index => $buyer_order)
                    @if(count($buyer_order->products()) > 0)
                        <a href="{{ URL::to('express/deliver/' . $buyer_order->id) }}" class="list-group-item">
                            {{--<h4 class="list-group-item-heading">{{ $buyer_order->b }}</h4>--}}
                            @foreach($buyer_order->products() as $p_index => $product)
                                <p class="list-group-item-text">#{{ $p_index + 1 }}: {{ $product->book->title }}</p>
                            @endforeach
                        </a>
                    @endif
                @endforeach
            </div>
        @endif
    </div>
@endsection