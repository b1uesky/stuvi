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

    <div class="container">
        {!! Breadcrumbs::render('shoppingCart') !!}

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
                            <div>
                                <span>
                                    @if(count($items) == 1)
                                        1 item:
                                    @else
                                        {{ count($items) }} items:
                                    @endif
                                </span>
                                <span class="price subtotal">${{ $subtotal }}</span>
                            </div>
                            <hr>
                            <div>
                                <a class="btn primary-btn" href="{{ url('/order/create') }}" role="button">Proceed to
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
