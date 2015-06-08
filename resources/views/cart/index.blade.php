<!-- Cart page -->



@extends('app')

<head>
    <title> Stuvi - Your Cart</title>
    <link rel="stylesheet" type="text/css" href="{{asset('/css/cart.css')}}"
</head>

@section('content')
    <div class="container" xmlns="http://www.w3.org/1999/html">
        @if (Session::has('message'))
            <div class="flash-message">{{ Session::get('message') }}</div>
        @endif
    </div>

    <div class="container col-xs-12 col-xs-offset-2 col-sm-8 col-sm-offset-2 cart-progress">
        <img class="img-responsive cart-line col-sm-offset-3" src="{{asset('/img/CART.png')}}" alt="Your cart progress">
    </div>

    <div class="container shopping-cart">
        <h1>Shopping Cart:
            @if ($items->count() < 1)
                <a href="{{ url('/cart/empty') }}">Your cart is empty</a>
            @endif
        </h1>
        <br>

        <table class="table table-striped table-responsive cart-table">
            <tr>
                <th>Book Title</th>
                <th>ISBN</th>
                <th>Price</th>
                <th>Remove</th>
            </tr>

            @forelse ($items as $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->options['item']->book->isbn }}</td>
                    <td>{{ $item->price }}</td>
                    @if ($item->options['item']->sold())
                        <p>Warning: This product has been sold.</p>
                    @endif
                    <td><a href="{{ url('/cart/rmv/'.$item->rowid) }}">Remove from Cart</a></td>
                </tr>

            @empty
                <p>You don't have any product in shopping cart.</p>
            @endforelse

        </table>



        @if ($items->count() > 0)
        <div class="container col-sm-4 col-sm-offset-8 total-checkout">
            <h3>Subtotal: {{ $total_price }}</h3>

            <h3><a href="{{ url('/order/create') }}">Proceed to Checkout</a></h3>

        </div>

        @endif

    </div>
@endsection