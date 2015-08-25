<!-- Cart page -->

@extends('layouts.textbook')

@section('title', 'Your Cart')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('/css/cart_index.css')}}">
    @endsection

    @section('content')

    <div class="container">

        {{-- Breadcrumb --}}
        @if(count($items) > 0)
            <div class="row margin-30">
                <nav>
                    <ol class="cd-multi-steps text-top">
                        <li class="current">
                            <span>Cart</span>
                        </li>
                        <li>
                            <span>Checkout</span>
                        </li>
                        <li>
                            <span>Done</span>
                        </li>
                    </ol>
                </nav>
            </div>
        @endif

        <div class="row shopping-cart">
            @if(count($items) > 0)
                {{-- Cart items --}}
                <div class="col-md-9">
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
                                        <img class="img-small"
                                             src="{{ config('aws.url.stuvi-book-img') . $item->product->book->imageSet->small_image }}"
                                             alt="">
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
                                <td>${{ $item->product->decimalPrice()}}</td>
                                {{-- Remove --}}
                                <td>
                                    <button type="button" class="close remove-cart-item" aria-label="Close"><span
                                                aria-hidden="true">&times;</span></button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                {{-- Subtotal --}}
                <div class="col-md-3">
                    <div class="panel panel-default text-center">
                        <div class="panel-heading">
                            <h3 class="panel-title">Subtotal</h3>
                        </div>
                        <div class="panel-body">
                            <table class="table table-panel">
                                <tr>
                                    <td class="text-left">
                                        <span class="cart-quantity">{{ count($items) }}</span>
                                        <span>item(s):</span>
                                    </td>
                                    <td class="text-right">
                                        <span class="price subtotal">${{ $subtotal }}</span>
                                    </td>
                                </tr>
                            </table>

                            <hr>

                            <div>
                                <a class="btn btn-primary" href="{{ url('/order/create') }}" role="button">Proceed to
                                    checkout</a>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="cart-empty text-center text-muted">
                    <h2>Your shopping cart is empty.</h2>
                </div>
            @endif
        </div>
    </div>


@endsection

@section('javascript')
    <script src="{{asset('/js/cart/index.js')}}"></script>
@endsection
