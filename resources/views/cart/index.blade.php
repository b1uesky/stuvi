<!-- Cart page -->

@extends('app')

@section('content')

    <head>
        <title> Stuvi - Your Cart</title>
        <link rel="stylesheet" type="text/css" href="{{asset('/css/cart.css')}}">
    </head>

    @if (Session::has('message'))
        @if (Session::get('alert-class') == 'alert-danger' or Session::get('alert-class') == 'alert-warning')
            <div class="container {{ Session::get('alert-class') }}" id="message-cont"
                 xmlns="http://www.w3.org/1999/html">
                <div class="flash-message" id="message"><i
                            class="fa fa-exclamation-triangle"></i> {{ Session::get('message') }}</div>
            </div>
        @elseif (Session::get('alert-class') == 'alert-info')
            <div class="container {{ Session::get('alert-class') }}" id="message-cont"
                 xmlns="http://www.w3.org/1999/html">
                <div class="flash-message" id="message"><i class="fa fa-info-circle"></i> {{ Session::get('message') }}
                </div>
            </div>
        @else
            <div class="container {{ Session::get('alert-class') }}" id="message-cont"
                 xmlns="http://www.w3.org/1999/html">
                <div class="flash-message" id="message"><i
                            class="fa fa-check-square-o"></i> {{ Session::get('message') }}</div>
            </div>
        @endif
    @endif

    <div class="row back-row">
        <a id="back-to-cart" href="javascript:history.back()" ><i class="fa fa-arrow-circle-left"></i>Back to Shopping</a>
    </div>

    <div class="container col-xs-12 col-xs-offset-2 col-sm-8 col-sm-offset-2 cart-progress">
        <img class="img-responsive cart-line col-sm-offset-3" src="{{asset('/img/CART.png')}}" alt="Your cart progress">
    </div>

    <!-- all of shopping cart info -->
    <div class="container shopping-cart">
        <h1>Shopping Cart
            @if ($items->count() < 1)
                <a href="{{ url('/cart/empty') }}">Your cart is empty</a>
            @endif
        </h1>
        <br>

        <!-- cart items -->
        <table class="table table-responsive cart-table">
        <thead>
            <tr class="active">
                <th>Book Title</th>
                <th>ISBN</th>
                <th>Price</th>
                <th>Remove</th>
            </tr>
        </thead>
            <!-- add a row for each item -->
            @forelse ($items as $item)
                <tr>
                    <!-- title -->
                    <td>{{ $item->name }}</td>
                    <!-- isbn -->
                    <td>{{ $item->options['item']->book->isbn }}</td>
                    <!-- price -->
                    <td>${{ $item->price }}</td>
                    <!-- remove -->
                    <td><a href="{{ url('/cart/rmv/'.$item->rowid) }}"><i class="fa fa-times btn-close"></i>
                        </a></td>
                </tr>
                <!-- how will this style?? -->
                @if ($item->options['item']->sold)
                    <tr class="warning" colspan="4">
                        <td>Warning: This product has been sold.</td>
                    </tr>
                @endif
            @empty
                <p>You don't have any product in shopping cart.</p>
            @endforelse

            <!-- coupon code, update cart, checkout -->
            @if ($items->count() > 0)
            <tfoot>
                <tr class="active row-cart-bottom">
                    <!-- apply coupon -->
                    <td><form class="form-inline coupon-form">
                            <div class="form-group">
                                <input type="text" class="form-control" id="coupon" placeholder="">
                                <label for="coupon"><a class="btn btn-default" href="#" role="button">
                                        Apply Coupon</a></label>
                            </div>
                        </form>
                    </td>
                    <!-- buffer -->
                    <td></td>
                    <!-- buffer -->
                    <td></td>
                    <!-- update cart -->
                    <td><a class="btn btn-default" href="#" role="button">Update Cart</a></td>
                </tr>
            </tfoot>

            @endif

        </table>

        <!-- total -->
        @if ($items->count() > 0)
        <div class="container col-sm-4 col-sm-offset-8 total-checkout">
            <table class="table table-responsive subtotal">
                <tr>
                    <td><b>Cart Subtotal</b></td>
                    <td>${{ $total_price }}</td>
                </tr>
            </table>
            <a class="btn btn-checkout" href="{{ url('/order/create') }}" role="button">
                Proceed to Checkout
            </a>
        </div>

        @endif

    </div>
@endsection
