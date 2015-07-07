@extends('app')

{{-- Not sure how to have title in @section('title') as a variable --}}
<head>
    <title>Stuvi - {{ $book->title }}</title>
</head>

@section('css')
    <link href="{{ asset('/css/textbook/textbook-show.css') }}" rel="stylesheet">
@endsection


@section('content')

    @include('textbook/textbook-nav')

    <div class="container">
        <div class="row textbook-row">
            <div class="col-sm-6">
                @if($book->imageSet->large_image)
                    <img id="textbook-img" src="{{ $book->imageSet->large_image }}" alt=""/>
                @endif
            </div>

            <div class="col-sm-6 textbook-info">
                <h1>{{ $book->title }}</h1>

                <div class="authors-container">
                    <span>by </span>
                    @foreach($book->authors as $author)
                        <span id="authors"><button class="btn btn-default author-btn">{{ $author->full_name }}</button></span>
                    @endforeach
                </div>
                <p>ISBN10: {{ $book->isbn10 }}</p>
                <p>ISBN13: {{ $book->isbn13 }}</p>

                <p>Edition: {{ $book->edition }}</p>

                <p>Number of Pages: {{ $book->num_pages }}</p>
                {{-- Author(s) --}}
                {{-- TODO: Make each author name looks like a tag --}}
                {{--<div class="">--}}
                {{--@if(count($book->authors) > 1)--}}
                {{--<span>Authors:</span>--}}
                {{--@foreach($book->authors as $author)--}}
                {{--<span>{{ $author->full_name }}</span>--}}
                {{--@endforeach--}}
                {{--@else--}}
                {{--<span>Author:</span>--}}
                {{--{{ $book->authors[0]->full_name }}--}}
                {{--@endif--}}
                {{--</div>--}}

            </div>
        </div>

        @if(count($book->availableProducts()) > 0)

            <div class="row table-row">

                <h3>Select one of our available books</h3>
                <table class="table table-responsive textbook-table" style="width:100%" border="1">
                    <thead>
                    <tr class="active">
                        <th>Price</th>
                        <th>Condition</th>
                        <th>Details</th>
                        <th>Add to Cart</th>
                    </tr>
                    </thead>
                    @foreach($book->availableProducts() as $product)
                        <tr>
                            <td>
                                <p id="price">${{ $product->price }}</p>
                            </td>
                            <td>
                                {{ $product->general_condition() }}
                            </td>
                            <td>
                                <a href="{{ url('textbook/buy/product/'.$product->id) }}">View Details</a>
                            </td>
                            <td class="cart-btn-col">
                                <a class="btn add-cart-btn" href="{{ url('cart/add/'.$product->id) }}" role="button">Add To Cart</a>
                            </td>
                        </tr>
                    @endforeach

                </table>
            </div>
        @else
            <h3>Sorry, this book is not available for now.</h3>
        @endif
    </div>

@endsection

@section('javascript')
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
@endsection