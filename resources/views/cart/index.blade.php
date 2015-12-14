<!-- Cart page -->

@extends('layouts.textbook')

@section('title', 'Your Cart')


@section('content')

    <div class="container shopping-cart">

        {{-- Breadcrumb --}}
        @if(count($items) > 0)
            <br>
            <div class="row">
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
            <br>

            <div class="row">
                {{-- Cart items --}}
                <div class="col-md-9">
                    <div class="panel panel-default">
                        <table class="table">
                            <thead>
                            <tr class="active">
                                <th>Book</th>
                                <th></th>
                                <th class="hidden-xs">ISBN</th>
                                <th>Price</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($items as $item)
                                <tr data-product-id="{{ $item->product_id }}">
                                    {{-- Book --}}
                                    <td>
                                        {{--Book image --}}
                                        <img class="img-responsive"
                                             src="{{ $item->product->book->imageSet->getImagePath('small') }}">
                                    </td>
                                    <td>
                                        {{-- Book title --}}
                                        <a href="{{ url('textbook/buy/product/'.$item->product->id) }}">
                                            {{ $item->product->book->title }}
                                        </a>
                                    </td>
                                    {{-- ISBN --}}
                                    <td class="hidden-xs">{{ $item->product->book->isbn10 }}</td>
                                    {{-- Price --}}
                                    <td>${{ $item->product->price }}</td>
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


                            <a class="btn btn-warning" href="{{ url('/order/create') }}" role="button">Proceed to checkout</a>

                            <hr>

                            <a href="{{ URL::previous() }}" class="btn btn-default">Continue shopping</a>

                            
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="jumbotron text-center">
                <h2>Your cart is empty...</h2>
                {{--<br>--}}
                {{--<p><a href="{{ url('textbook/search') }}" class="btn btn-primary btn-lg">Find a book</a></p>--}}
            </div>
        @endif

        <div class="cart-empty hidden">
            <div class="jumbotron text-center">
                <h2>Your cart is empty...</h2>
                {{--<br>--}}
                {{--<p><a href="{{ url('textbook/search') }}" class="btn btn-primary btn-lg">Find a book</a></p>--}}
            </div>
        </div>

    </div>


@endsection
