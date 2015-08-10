<!-- Cart page -->

@extends('app')

@section('title', 'Your Cart')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('/css/cart_index.css')}}">
@endsection

@section('content')

    @include('includes.textbook.flash-message')

    <!-- back link -->
    <div class="container-fluid">
        <div class="row back-row">
            <a id="back-to-cart" onclick="goBack()"><i class="fa fa-arrow-circle-left"></i> Go Back</a>
        </div>
    </div>

    <!-- img of cart progress bar -->
            <div class="container col-xs-10 col-xs-offset-2 col-sm-8 col-sm-offset-2 cart-progress">
        <img class="img-responsive cart-line col-sm-offset-3" src="{{asset('/img/CART.png')}}" alt="Your cart progress">
    </div>

    <!-- all of shopping cart info -->
    <div class="container shopping-cart">
        <br>
        <br>
        @if ($items->count() > 0)
        <!-- cart items -->
        <table class="table table-responsive cart-table">
        <!-- table headers -->
        <thead>
            <tr class="active">
                <th>Book Title</th>
                <th>ISBN</th>
                <th>Price</th>
                <th>Remove</th>
            </tr>
        </thead>
        @endif
            <!-- add a row for each item -->
            @forelse ($items as $item)
                <tr>
                    <!-- title -->
                    <td><a href="{{ url('textbook/buy/product/'.$item->product->id) }}">{{ $item->product->book->title }}</a></td>
                    <!-- isbn -->
                    <td>{{ $item->product->book->isbn10 }}</td>
                    <!-- price -->
                    <td>${{ $item->product->decimalPrice()}}</td>
                    <!-- remove -->
                    <td><a href="{{ url('/cart/rmv/'.$item->product->id) }}"><i class="fa fa-times btn-close"></i>

                        </a></td>
                </tr>
                <!-- how will this style?? -->
                @if ($item->product->sold)
                    <tr class="warning">
                        <td>Warning: This product has been sold.</td>
                    </tr>
                @endif
            @empty
                <p><i>You don't have any products in your shopping cart.</i></p>
            @endforelse

            <!-- coupon code, update cart, checkout -->
            @if ($items->count() > 0)
            <tfoot>
                <tr class="active row-cart-bottom">
                    <!-- apply coupon -->
                    <td><form class="form-inline coupon-form">
                            <div class="form-group">
                                <input type="text" class="form-control" id="coupon" placeholder="">
                                <label for="coupon">
                                    <a class="btn btn-default secondary-btn" href="#" role="button">Apply Coupon</a>
                                </label>
                            </div>
                        </form>
                    </td>
                    <!-- buffer -->
                    <td></td>
                    <!-- buffer -->
                    <td></td>
                    <!-- update cart -->
                    <td><a class="btn btn-default secondary-btn" href="/cart/update" role="button">Update Cart</a></td>
                </tr>
            </tfoot>
            @endif
        </table>
        <!-- total & checkout-->
        @if ($items->count() > 0)
        <div class="container col-sm-4 col-sm-offset-8 total-checkout">
            <table class="table table-responsive subtotal">
                <tr>
                    <td class="no-border-top"><b>Tax</b></td>
                    <td class="no-border-top">${{ \App\Helpers\Price::convertIntegerToDecimal($tax) }}</td>
                </tr>
                <tr>
                    <td class="no-border-top"><b>Service Fee</b></td>
                    <td class="no-border-top">${{ \App\Helpers\Price::convertIntegerToDecimal($fee) }}</td>
                </tr>
                <tr>
                    <td class="no-border-top"><b>Discount</b></td>
                    <td class="no-border-top">- ${{ \App\Helpers\Price::convertIntegerToDecimal($discount) }}</td>
                </tr>
                <tr>
                    <td><b>Grand Total</b></td>
                    <td>${{ \App\Helpers\Price::convertIntegerToDecimal($subtotal) }}</td>
                </tr>
            </table>
            <a class="btn primary-btn btn-checkout" href="{{ url('/order/create') }}" role="button">
                Proceed to Checkout
            </a>
        </div>
        @endif
    </div>
@endsection

@section('javascript')
    <script>
        function goBack() {
            window.history.back();
        }
    </script>
@endsection
