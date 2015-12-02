<div class="row">

    {{-- book image --}}
    <div class="col-md-2 col-xs-4">
        <a href="{{ url("textbook/buy/product/".$product->id) }}">
            <img class="img-responsive" src="{{ $product->book->imageSet->getImagePath('small') }}">
        </a>
    </div>

    {{-- book details --}}
    <div class="col-md-10 col-xs-8">

        {{-- title --}}
        <div class="row">
            <h4 class="no-margin-top">
                <a href="{{ url("textbook/buy/product/".$product->id) }}"><strong>{{ $product->book->title }}</strong></a>
            </h4>
        </div>

        {{-- authors --}}
        <div class="row padding-bottom-5">
            <span class="text-muted">
                @foreach($product->book->authors as $i => $author)
                    @if($i == 0)
                        <span>{{ $author->full_name }}</span>
                    @else
                        <span>, {{ $author->full_name }}</span>
                    @endif
                @endforeach
            </span>
        </div>

        {{-- Sale price --}}
        <div class="row padding-bottom-5">
            Sale price: <span class="price">${{ $product->decimalPrice() }}</span>
        </div>

        @if($product->accept_trade_in && $product->trade_in_price > 0)
            {{-- Trade-in price --}}
            <div class="row padding-bottom-5">
                Trade-in price: <span class="price">${{ $product->trade_in_price }}</span>
            </div>
        @endif

        {{-- isbn 10 --}}
        <div class="row">
            <span>ISBN-10: </span>
            <span>{{ $product->book->isbn10 }}</span>
        </div>

        {{-- isbn 13 --}}
        <div class="row">
            <span>ISBN-13: </span>
            <span>{{ $product->book->isbn13 }}</span>
        </div>

        {{-- number of views --}}
        {{--@if($product->seller_id == Auth::id())--}}

            {{--<div class="row">--}}
                {{--<span>Views: </span>--}}
                {{--<span>{{ $product->views() }}</span>--}}
            {{--</div>--}}
        {{--@endif--}}

        @if(isset($seller_order) && $seller_order->isCancelledBySeller())
            <div class="row text-muted">
                <span class="glyphicon glyphicon-info-sign"></span> Cancelled by seller
            </div>
        @endif
    </div>

</div>