@extends('app')

@section('content')
    <div class="container">
        @if (Session::has('message'))
            <div class="flash-message">{{ Session::get('message') }}</div>
        @endif
    </div>
    <div class="container">
        <h1>Cart items:</h1>
        @forelse ($items as $item)
            Book title: {{ $item->name }} </br>
                 isbn:  {{ $item->options['item']->book->isbn }} </br>
                 price: {{ $item->price }} </br>
            <a href="{{ url('/cart/rmv/'.$item->rowid) }}">Remove from Cart</a><br>
            ----------------------------------------------------------------------------------------
        @empty
            <p>You don't have any product in shopping cart.</p>
        @endforelse

    </div>
@endsection