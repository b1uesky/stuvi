@extends('textbook')

@section('content')
    <head>
        <link href="{{ asset('/css/textbook-list.css') }}" rel="stylesheet">
        <title>Search Results</title>
    </head>

    <div class="container-fluid textbook-list-container">
        <h1 id="search-term">Search results for *search term*</h1>

        <div class="container textbook-list">
            <table class="table table-responsive textbook-table">
                <!-- new row for each book -->
                @foreach($books as $book)
                    <tr class="textbook-item">
                        <td class="textbook-img-container">
                            <img class="textbook-img" src="{{ $book->imageSet->large_image }}">
                        </td>
                        <td class="textbook-info-1">
                            <span class="textbook-title"><a href="#">{{ $book->title }}</a></span><br>
                            <span class="textbook-author">by {{ $book->author }}</span><br>
                            <span class="textbook-isbn">ISBN: {{ $book->isbn }}</span>
                            <br>
                            <span class="textbook-price">$18.00</span> <br>
                            {{--<button type="button" class="btn btn-link textbook-btn-add-cart">--}}
                            {{--Add to Cart</button>--}}
                        </td>
                        <td class="table-offset"></td>
                        <td class="textbook-info-2">
                            <!-- each class the book support -->
                            {{--<h5>Classes</h5>--}}
                            {{--<span class="textbook-class"><a href="#">BU:SMG SM131</a></span>--}}
                            <a class="btn add-cart-btn" href="#" role="button">Add To Cart</a>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
        {{--@foreach($books as $book)--}}
        {{--<div class="">--}}
        {{--<div class="">--}}
                        {{-- Link to each individual book --}}
        {{--<a href="{{ url('textbook/buy/textbook/'.$book->id) }}">--}}
        {{--Title: {{ $book->title }}--}}
        {{--</a>--}}
        {{--</div>--}}
        {{--<div class="">ISBN: {{ $book->isbn }}</div>--}}
        {{--</div>--}}
        {{--<hr>--}}
        {{--@endforeach--}}
    </div>
@endsection
