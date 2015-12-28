{{-- /textbook/buy/# --}}

@extends('layouts.textbook')

@section('title',$book->title)

@section('content')

    <div class="container">

        <div class="row">
            <ol class="breadcrumb">
                <li><a href="{{ url('/') }}">Home</a></li>

                <li>
                    <a href="{{ url('textbook/search?query=' . $query) }}">Search results</a>
                </li>

                <li class="active">{{ $book->title }}</li>
            </ol>
        </div>


        <div class="book-details">
            @include('includes.textbook.book-details-with-actions')
        </div>


        <br>

        @if(count($products) > 0)

            {{-- Product list --}}
            <div class="row">
                <div class="col-xs-12">
                    <table class="table" data-sortable>
                            <thead>
                            <tr>
                                <th class="col-xs-2">Price</th>
                                <th class="col-xs-2">Condition</th>
                                <th class="col-xs-6 hidden-xs">Images</th>
                                <th class="col-xs-2"></th>
                            </tr>
                            </thead>

                            <?php $loggedin = Auth::check();?>

                            @foreach($products as $product)
                                <tr>
                                    <td class="price">
                                        ${{ $product->price }}
                                    </td>
                                    <td>
                                        <strong>{{ $product->general_condition() }}</strong>
                                    </td>
                                    <td class="container-flex hidden-xs">
                                        @foreach($product->images as $image)
                                            <div>
                                                <img class="img-rounded img-small margin-5 full-width"
                                                     src="{{ $image->getImagePath('large') }}"
                                                     data-action="zoom">
                                            </div>
                                        @endforeach
                                    </td>
                                    <td>
                                        <a href="{{ url('textbook/buy/product/'.$product->id.'?query='.$query) }}" class="btn btn-primary btn-block margin-bottom-5">
                                            View details
                                        </a>

                                        @if($loggedin)
                                            @if($product->isInCart(Auth::user()->id))
                                                <a class="btn btn-default btn-block add-cart-btn disabled" href="#" role="button">
                                                    Added to cart
                                                </a>
                                            @elseif(!$product->isSold())
                                                @if($product->seller_id != Auth::id())
                                                    <form method="post" class="add-to-cart" action="{{ url('cart/add/' . $product->id) }}">
                                                        {!! csrf_field() !!}
                                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                        <button type="submit" class="btn btn-default btn-block add-cart-btn">
                                                            Add to cart
                                                        </button>
                                                    </form>
                                                @endif
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                            @endforeach

                        </table>
                </div>
            </div>
        @endif

    </div>

@endsection
