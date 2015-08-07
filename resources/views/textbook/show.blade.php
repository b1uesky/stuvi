{{-- /textbook/buy/# --}}

@extends('app')

@section('title',$book->title)

@section('css')
    <link href="{{ asset('/css/textbook_show.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('libs/jquery-ui/themes/smoothness/jquery-ui.min.css') }}">
@endsection

@section('searchbar')
    @include('includes.textbook.searchbar')
@endsection

@section('content')

    @include('textbook/textbook-nav')

    @include('includes.textbook.flash-message')

    <div class="container">
        <div class="row textbook-row">
            <div class="col-sm-6">
                <img id="textbook-img"
                     src="{{ $book->imageSet->large_image or config('book.default_image_path.large') }}"
                     alt="Book Image"/>
            </div>

            <div class="col-sm-6 textbook-info">
                <h1>{{ $book->title }}</h1>

                <div class="authors-container">
                    <span>by </span>
                    <?php $bookCounter = 0; ?>
                    @foreach($book->authors as $author)
                        @if($bookCounter == 0)
                            <span id="authors">{{ $author->full_name }}</span>
                        @else
                                <span id="authors">, {{ $author->full_name }}</span>
                        @endif
                        <?php $bookCounter++ ?>
                    @endforeach
                </div>
                <p>ISBN10: {{ $book->isbn10 }}</p>
                <p>ISBN13: {{ $book->isbn13 }}</p>
                <p>Number of Pages: {{ $book->num_pages }}</p>
            </div>
        </div>

        @if(count($book->availableProducts()) > 0)

            <div class="row table-row">

                <h4 id="h4-1">Select one of our available books</h4>

                <div id="book-options-links">
                    {{-- if the user is not logged in --}}
                    @if(Auth::guest())
                        <p>Please <a data-toggle="modal" href="#login-modal">Login</a> or <a data-toggle="modal" href="#signup-modal">Sign up</a> to buy or sell a textbook.</p>
                    @else
                        <p>Have one to sell? <a href="{{ url('textbook/sell/product/'.$book->id.'/create') }}">Sell yours now.</a></p>
                    @endif
                </div>

                <table class="table table-responsive textbook-table" style="width:100%" border="1">
                    <thead>
                    <tr class="active">
                        <th>Price</th>
                        <th>Condition</th>
                        <th>Details</th>
                        @if(Auth::check())
                            <th>Add to Cart</th>
                        @endif
                    </tr>
                    </thead>
                    @foreach($book->availableProducts() as $product)
                        <tr>
                            <td>
                                <p id="price">${{ $product->decimalPrice() }}</p>
                            </td>
                            <td>
                                {{ $product->general_condition() }}
                            </td>
                            <td>
                                <a href="{{ url('textbook/buy/product/'.$product->id) }}">View Details</a>
                            </td>
                            @if(Auth::check())
                                <td class="cart-btn-col">
                                    @if($product->isInCart(Auth::user()->id))
                                        <a class="btn primary-btn add-cart-btn disabled" href="#" role="button" id="added-to-cart-btn">
                                            Added to cart</a>
                                    @elseif($product->seller == Auth::user())
                                        <a class="btn primary-btn add-cart-btn disabled" href="#" role="button">Posted by
                                            you</a>
                                    @else
                                        <a class="btn primary-btn add-cart-btn" href="{{ url('cart/add/'.$product->id) }}"
                                           role="button" id="add-cart-btn" onClick="added()">Add to cart</a>
                                    @endif
                                </td>
                            @endif
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
    <script src="{{ asset('js/navbar.js') }}"></script>
    <script src="{{ asset('libs/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('js/autocomplete.js')}} "></script>
@endsection