{{--textbook/buy/product/#--}}


@extends('layouts.textbook')

<title>Stuvi - Book Details - {{ $product->book->title }} </title>

@section('searchbar')
    @include('includes.textbook.searchbar')
@endsection

@section('content')

    <?php $book = $product->book; ?>

    <div class="container">

        <div class="row">
            <ol class="breadcrumb">
                <li><a href="{{ url('textbook/buy') }}">Home</a></li>
                <li>
                    @if(Auth::check())
                        <a href="{{ url('textbook/buy/search?query=' . $query) }}">Search results</a>
                    @else
                        <a href="{{ url('textbook/buy/search?query=' . $query . '&university_id=' . $university_id) }}">Search results</a>
                    @endif
                </li>
                <li>
                    @if(Auth::check())
                        <a href="{{ url('textbook/buy/' . $product->book->id . '?query=' . $query) }}">{{ $product->book->title }}</a>
                    @else
                        <a href="{{ url('textbook/buy/' . $product->book->id . '?query=' . $query . '&university_id=' . $university_id) }}">{{ $product->book->title }}</a>
                    @endif
                </li>
                <li class="active">Details</li>
            </ol>
        </div>

        <div class="page-header">
            <h1>{{ $book->title }}</h1>
        </div>

        <div class="row container-flex">
                @forelse($product->images as $index => $image)
                    <div class="margin-5">
                        <img class="img-rounded full-width max-width-380" src="{{ $image->getImagePath('large') }}" data-action="zoom">
                    </div>
                @empty
                    <h3>No images were provided.</h3>
                @endforelse
        </div>

        <br>

        <div class="row">
            <div class="col-sm-9">
                <!-- product conditions -->
                <table class="table">

                    <tbody>
                    <tr>
                        <th class="col-sm-6 col-xs-7">Price</th>
                        <td class="col-sm-6 col-xs-5 price">${{ $product->decimalPrice() }}</td>
                    </tr>

                    <!-- General Condition -->
                    <tr>
                        <th>
                            General condition
                            <span class="glyphicon glyphicon-question-sign text-muted cursor-pointer" data-toggle="modal" data-target=".condition-modal"></span>
                        </th>

                        <td>{{ config('product.conditions.general_condition')[$product->condition->general_condition] }}</td>
                    </tr>
                    <!-- Highlights / Notes -->
                    <tr>
                        <th>
                            Highlights/Notes
                            <span class="glyphicon glyphicon-question-sign text-muted cursor-pointer" data-toggle="modal" data-target=".highlight-modal"></span>
                        </th>
                        <td>{{ config('product.conditions.highlights_and_notes')[$product->condition->highlights_and_notes] }}</td>
                    </tr>
                    <!-- Damaged Pages -->
                    <tr>
                        <th>
                            Damaged pages
                            <span class="glyphicon glyphicon-question-sign text-muted cursor-pointer" data-toggle="modal" data-target=".damage-modal"></span>
                        </th>
                        <td>{{ config('product.conditions.damaged_pages')[$product->condition->damaged_pages] }}</td>
                    </tr>
                    <!-- Broken Binding -->
                    <tr>
                        <th>
                            Broken binding
                            <span class="glyphicon glyphicon-question-sign text-muted cursor-pointer" data-toggle="modal" data-target=".binding-modal"></span>

                        </th>
                        <td>{{ config('product.conditions.broken_binding')[$product->condition->broken_binding] }}</td>
                    </tr>
                    <!-- Seller Description -->
                    @if($product->condition->hasDescription())
                        <tr>
                            <th>Additional description</th>
                            <td>
                                {{ $product->condition->description }}
                            </td>
                        </tr>
                    @endif

                    <tr>
                        <th>Posted time</th>
                        <td>
                            <span class="product-posted-time">{{ $product->created_at }}</span>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <div class="col-sm-3">
                @if(Auth::check())
                    @if($product->isInCart(Auth::user()->id))
                        <a class="btn btn-primary btn-block add-cart-btn disabled" href="#" role="button">Added
                            To Cart</a>
                    @elseif(!$product->isSold() && $product->seller == Auth::user())
                        <a href="{{ url('/textbook/sell/product/'.$product->id.'/edit') }}"
                           class="btn btn-primary btn-block">Edit</a>

                        <button type="button" class="btn btn-danger btn-block" data-toggle="modal"
                                data-target="#delete-product"
                                data-product-id="{{ $product->id }}"
                                data-book-title="{{ $product->book->title }}">Delete</button>
                    @else
                        <form method="post" class="add-to-cart" action="{{ url('cart/add/' . $product->id) }}">
                            {!! csrf_field() !!}
                            <input type="submit" class="btn btn-primary btn-block add-cart-btn" value="Add to cart">
                        </form>
                    @endif
                @else
                    <span>Please <a data-toggle="modal" href="#login-modal">Login</a> or <a
                                data-toggle="modal" href="#signup-modal">Sign up</a> to buy this textbook.
            </span>
                @endif
            </div>
        </div>

        <br>

    </div>


@endsection

@include('includes.modal.delete-product')
@include('includes.modal.product-conditions')
