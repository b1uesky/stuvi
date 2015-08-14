<!-- Cart page -->

@extends('app')

@section('title', 'Your Cart')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('/css/cart_index.css')}}">
    @endsection

    @section('content')

    @include('includes.textbook.flash-message')
{{--
    <!-- TODO: modifiy breadcrumbs to add greyed options for -> checkout -> confirm -->
    <div class="container">
                {!! Breadcrumbs::render('shoppingCart') !!}
    </div>--}}
{{--

    <div class="container cart-prog">
        <div class="cart-prog-arrow"></div>
    </div>
--}}

    <!-- all of shopping cart info -->
    {{--<div class="container shopping-cart">--}}
        {{--{!! Breadcrumbs::render('shoppingCart') !!}--}}

        {{--@if ($items->count() > 0)--}}
            {{--<!-- cart items -->--}}
            {{--<table class="table table-responsive cart-table">--}}
            {{--<!-- table headers -->--}}
            {{--<thead>--}}
            {{--<tr class="active">--}}
                {{--<th>Book Title</th>--}}
                {{--<th>ISBN</th>--}}
                {{--<th>Price</th>--}}
                {{--<th>Remove</th>--}}
            {{--</tr>--}}
            {{--</thead>--}}
                    {{--<!-- add a row for each item -->--}}
            {{--@forelse ($items as $item)--}}
                {{--<tr class="cart-item" value="{{ $item->product_id }}">--}}
                    {{--<!-- title -->--}}
                    {{--<td>--}}
                        {{--<a href="{{ url('textbook/buy/product/'.$item->product->id) }}">{{ $item->product->book->title }}</a>--}}
                    {{--</td>--}}
                    {{--<!-- isbn -->--}}
                    {{--<td>{{ $item->product->book->isbn10 }}</td>--}}
                    {{--<!-- price -->--}}
                    {{--<td>${{ $item->product->decimalPrice()}}</td>--}}
                    {{--<!-- remove -->--}}
                    {{--<td><a class="fa fa-times btn-close remove-cart-item"></a></td>--}}
                {{--</tr>--}}
                {{--<!-- how will this style?? -->--}}
                {{--@if ($item->product->sold)--}}
                    {{--<tr class="warning">--}}
                        {{--<td>Warning: This product has been sold.</td>--}}
                    {{--</tr>--}}
                {{--@endif--}}
            {{--@empty--}}
                {{--<p><i>You don't have any products in your shopping cart.</i></p>--}}
                {{--@endforelse--}}

                        {{--<!-- coupon code, update cart, checkout -->--}}
                {{--@if ($items->count() > 0)--}}
                    {{--<tfoot>--}}
                    {{--<tr class="active row-cart-bottom">--}}
                        {{--<!-- apply coupon -->--}}
                        {{--<td>--}}
                            {{--<form class="form-inline coupon-form">--}}
                                {{--<div class="form-group">--}}
                                    {{--<input type="text" class="form-control" id="coupon" placeholder="">--}}
                                    {{--<label for="coupon">--}}
                                        {{--<a class="btn btn-default secondary-btn" href="#" role="button">Apply Coupon</a>--}}
                                    {{--</label>--}}
                                {{--</div>--}}
                            {{--</form>--}}
                        {{--</td>--}}
                        {{--<!-- buffer -->--}}
                        {{--<td></td>--}}
                        {{--<!-- buffer -->--}}
                        {{--<td></td>--}}
                        {{--<!-- update cart -->--}}
                        {{--<td><a class="btn btn-default secondary-btn" href="/cart/update" role="button">Update Cart</a>--}}
                        {{--</td>--}}
                    {{--</tr>--}}
                    {{--</tfoot>--}}
                {{--@endif--}}
        {{--</table>--}}
        {{--@endif--}}
        {{--<!-- total & checkout-->--}}
        {{--@if ($items->count() > 0)--}}
            {{--<div class="container col-sm-4 col-sm-offset-8 total-checkout">--}}
                {{--<table class="table table-responsive subtotal">--}}
                    {{--<tr>--}}
                        {{--<td class="no-border-top"><b>Tax</b></td>--}}
                        {{--<td class="no-border-top tax">${{ \App\Helpers\Price::convertIntegerToDecimal($tax) }}</td>--}}
                    {{--</tr>--}}
                    {{--<tr>--}}
                        {{--<td class="no-border-top"><b>Service Fee</b></td>--}}
                        {{--<td class="no-border-top fee">${{ \App\Helpers\Price::convertIntegerToDecimal($fee) }}</td>--}}
                    {{--</tr>--}}
                    {{--<tr>--}}
                        {{--<td class="no-border-top"><b>Discount</b></td>--}}
                        {{--<td class="no-border-top discount">---}}
                            {{--${{ \App\Helpers\Price::convertIntegerToDecimal($discount) }}</td>--}}
                    {{--</tr>--}}
                    {{--<tr>--}}
                        {{--<td><b>Grand Total</b></td>--}}
                        {{--<td class="total">${{ \App\Helpers\Price::convertIntegerToDecimal($subtotal) }}</td>--}}
                    {{--</tr>--}}
                {{--</table>--}}
                {{--<a class="btn primary-btn btn-checkout" href="{{ url('/order/create') }}" role="button">--}}
                    {{--Proceed to checkout--}}
                {{--</a>--}}
            {{--</div>--}}
        {{--@endif--}}
    {{--</div>--}}

    <div class="container shopping-cart">
        {!! Breadcrumbs::render('shoppingCart') !!}

        <div class="row">
            {{-- Cart items --}}
            <div class="col-sm-9">
                @if(count($items) > 0)
                    <table class="table table-responsive table-default">
                        <thead>
                            <tr>
                                <th>Book</th>
                                <th></th>
                                <th>ISBN</th>
                                <th>Price</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $item)
                                <tr value="{{ $item->product_id }}">
                                    {{-- Book --}}
                                    <td>
                                        {{-- Book image --}}
                                        @if($item->product->book->imageSet->small_image)
                                            <img class="img-small" src="{{ config('aws.url.stuvi-book-img') . $item->product->book->imageSet->small_image }}" alt="">
                                        @else
                                            <img src="{{ config('book.default_image_path') }}" alt="">
                                        @endif
                                    </td>
                                    <td>
                                        {{-- Book title --}}
                                        <a href="{{ url('textbook/buy/product/'.$item->product->id) }}">{{ $item->product->book->title }}</a>
                                    </td>
                                    {{-- ISBN --}}
                                    <td>{{ $item->product->book->isbn10 }}</td>
                                    {{-- Price --}}
                                    <td class="price">${{ $item->product->decimalPrice()}}</td>
                                    {{-- Remove --}}
                                    <td><button type="button" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div>Your Shopping Cart is empty.</div>
                @endif
            </div>
            {{-- Subtotal --}}
            <div class="col-sm-3">
                @if(count($items) > 0)
                    <div class="panel panel-default text-center">
                        <div class="panel-heading">
                            <h3 class="panel-title">Subtotal</h3>
                        </div>
                        <div class="panel-body">
                            <div>
                                <span>
                                    @if(count($items) == 1)
                                        1 item:
                                    @else
                                        {{ count($items) }} items:
                                    @endif
                                </span>
                                <span class="price">${{ $subtotal }}</span>
                            </div>
                            <hr>
                            <div>
                                <a class="btn primary-btn" href="{{ url('/order/create') }}" role="button">Proceed to checkout</a>
                            </div>
                        </div>
                    </div>
                @else
                @endif
            </div>
        </div>
    </div>


@endsection

@section('javascript')
    <script src="{{asset('/js/cart/index.js')}}"></script>
@endsection
