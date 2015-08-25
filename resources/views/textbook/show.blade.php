{{-- /textbook/buy/# --}}

@extends('layouts.textbook')

@section('title',$book->title)

@section('css')
    <link href="{{ asset('/css/textbook_show.css') }}" rel="stylesheet">
@endsection

@section('searchbar')
    @include('includes.textbook.searchbar')
@endsection

@section('content')

    @include('textbook/textbook-nav')

    <div class="container">

        <div class="page-header">
            <h1>{{ $book->title }}</h1>
        </div>

        {{-- Book info --}}
        <div class="row">

            {{-- Image --}}
            <div class="col-xs-4 col-sm-3 col-md-2">
                @if($book->imageSet->medium_image)
                    <img class="img-responsive"
                         src="{{ config('aws.url.stuvi-book-img') . $book->imageSet->medium_image }}">
                @else
                    <img class="img-responsive" src="{{ config('book.default_image_path.medium') }}">
                @endif
            </div>

            {{-- Details --}}
            <div class="col-xs-8 col-sm-9 col-md-10">
                <div class="va-container va-container-h va-container-v">
                    <div class="va-top">
                        <table class="table table-book-details">
                            <tr>
                                <th class="col-xs-6 col-sm-3 col-md-2">
                                    @if(count($book->authors) > 1)
                                        Authors
                                    @else
                                        Author
                                    @endif
                                </th>
                                <td class="col-xs-6 col-sm-9 col-md-10">
                                    @foreach($book->authors as $index => $author)
                                        @if($index == 0)
                                            <span class="author">{{ $author->full_name }}</span>
                                        @else
                                            <span class="author">, {{ $author->full_name }}</span>
                                        @endif
                                    @endforeach
                                </td>
                            </tr>

                            <tr>
                                <th>ISBN-10</th>
                                <td>{{ $book->isbn10 }}</td>
                            </tr>

                            <tr>
                                <th>ISBN-13</th>
                                <td>{{ $book->isbn13 }}</td>
                            </tr>

                            <tr>
                                <th>Number of pages</th>
                                <td>{{ $book->num_pages }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

            </div>
        </div>

        <br/>

        {{-- Product list --}}
        <div class="row">
            @if(count($book->availableProducts()) > 0)
                <table class="table table-responsive table-default">
                    <thead>
                    <tr class="active">
                        <th class="col-xs-3">Price</th>
                        <th class="col-xs-3">Condition</th>
                        <th class="col-xs-3">Details</th>
                        <th class="col-xs-3"></th>
                    </tr>
                    </thead>
                    @foreach($book->availableProducts() as $product)
                        <tr>
                            <td class="price">
                                ${{ $product->decimalPrice() }}
                            </td>
                            <td>
                                {{ $product->general_condition() }}
                            </td>
                            <td>
                                <a href="{{ url('textbook/buy/product/'.$product->id) }}">View Details</a>
                            </td>

                            <td class="text-right">
                                @if(Auth::check())
                                    @if($product->isInCart(Auth::user()->id))
                                        <a class="btn btn-primary add-cart-btn disabled width-130" href="#"
                                           role="button" id="added-to-cart-btn">
                                            Added to cart</a>
                                    @elseif($product->seller == Auth::user())
                                        <a class="btn btn-muted add-cart-btn disabled width-130" href="#" role="button">Posted
                                            by
                                            you</a>
                                    @else
                                        <form method="post" class="add-to-cart">
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <input class="btn btn-primary add-cart-btn width-130" type="submit" value="Add to cart">
                                        </form>
                                    @endif
                                @endif
                            </td>

                        </tr>
                    @endforeach

                </table>
            @else
                <h4 class="text-center">Sorry, this book is not available for now.</h4>
            @endif

            <div class="text-center">
                {{-- if the user is not logged in --}}
                @if(Auth::guest())
                    @if(count($book->availableProducts()) > 0)
                        <p>Please <a data-toggle="modal" href="#login-modal">Login</a> or <a data-toggle="modal"
                                                                                             href="#signup-modal">Sign
                                up</a> to buy or sell a textbook.</p>
                    @endif
                @else
                    <p>Have one to sell? <a href="{{ url('textbook/sell/product/'.$book->id.'/create') }}">Sell yours
                            now.</a></p>
                @endif
            </div>
        </div>


    </div>

@endsection

@section('javascript')
    <script src="{{ asset('js/navbar.js') }}"></script>
    <script src="{{ asset('libs/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('js/autocomplete.js')}} "></script>
    <script src="{{ asset('js/cart.js') }}"></script>
@endsection