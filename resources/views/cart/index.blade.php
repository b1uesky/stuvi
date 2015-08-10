<!-- Cart page -->

@extends('app')

@section('title', 'Your Cart')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('/css/cart_index.css')}}">
@endsection

@section('content')

    @include('includes.textbook.flash-message')

    <!-- back link -->

    <!-- img of cart progress bar -->
            <div class="container col-xs-10 col-xs-offset-2 col-sm-8 col-sm-offset-2 cart-progress">
                {!! Breadcrumbs::render('shoppingCart') !!}
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
                <tr class="cart-item" value="{{ $item->product_id }}">
                    <!-- title -->
                    <td><a href="{{ url('textbook/buy/product/'.$item->product->id) }}">{{ $item->product->book->title }}</a></td>
                    <!-- isbn -->
                    <td>{{ $item->product->book->isbn10 }}</td>
                    <!-- price -->
                    <td>${{ $item->product->decimalPrice()}}</td>
                    <!-- remove -->
                    <td><a class="fa fa-times btn-close remove-cart-item"></a></td>
                    {{--<td><button><i class="fa fa-times btn-close">{{ $item->product_id }}</i></button></td>--}}
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
                    <td class="no-border-top tax">${{ \App\Helpers\Price::convertIntegerToDecimal($tax) }}</td>
                </tr>
                <tr>
                    <td class="no-border-top"><b>Service Fee</b></td>
                    <td class="no-border-top fee">${{ \App\Helpers\Price::convertIntegerToDecimal($fee) }}</td>
                </tr>
                <tr>
                    <td class="no-border-top"><b>Discount</b></td>
                    <td class="no-border-top discount">- ${{ \App\Helpers\Price::convertIntegerToDecimal($discount) }}</td>
                </tr>
                <tr>
                    <td><b>Grand Total</b></td>
                    <td class="total">${{ \App\Helpers\Price::convertIntegerToDecimal($subtotal) }}</td>
                </tr>
            </table>
            <a class="btn primary-btn btn-checkout" href="{{ url('/order/create') }}" role="button">
                Proceed to checkout
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
    <script>
        $(document).ready(function(){
            $(".remove-cart-item").click(function(){
                var tr = $(this).parent('td').parent('tr');
                $(this).parent('td').html('<a class="fa fa-spinner fa-pulse fa-1x loading"></a>');
                $.ajax({
                    url: location.protocol + '//' + document.domain + '/cart/rmv',
                    dataType: 'json',
                    data: {
                        product_id: tr.attr("value")
                    },
                    success: function (data) {
                        console.log(data);
                        if (data['removed']) {
                            tr.html("<td>".concat(data['message'],"</td><td></td><td></td><td></td>"));
                            $(".fee").text('$'.concat(data['fee'] / 100));
                            $(".discount").text('- $'.concat(data['discount'] / 100));
                            $(".tax").text('$'.concat(data['tax'] / 100));
                            $(".total").text('$'.concat(data['total'] / 100))
                        }
                    }
                });
            });
        });
    </script>
@endsection
