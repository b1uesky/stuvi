<div class="row">
    <?php $count_product = count($book->availableProducts()); ?>

    {{-- book image --}}
    <div class="col-md-2 col-sm-3 col-xs-4">
        <a href="{{ url("textbook/buy/".$book->id) }}">
            <img class="img-responsive" src="{{ $book->imageSet->getImagePath('small') }}">
        </a>
    </div>

    {{-- book details --}}
    <div class="col-md-8 col-sm-7 col-xs-8">

        {{-- title --}}
        <div class="row">
            <h4 class="no-margin-top">
                <a href="{{ url("textbook/buy/".$book->id.'?query=' . Input::get('query')) }}"><strong>{{ $book->title }}</strong></a>
            </h4>
        </div>

        {{-- authors --}}
        <div class="row padding-bottom-5">
            <span class="text-muted">
                @foreach($book->authors as $i => $author)
                    @if($i == 0)
                        <span>{{ $author->full_name }}</span>
                    @else
                        <span>, {{ $author->full_name }}</span>
                    @endif
                @endforeach
            </span>
        </div>

        {{-- Prices --}}
        @if($count_product > 0)
            <div class="row padding-bottom-5">
                {{-- price --}}
                <span class="text-bold">
                    @if($count_product > 1)
                        <span class="price">${{ $book->decimalLowestPrice() }}</span>
                        <span class="text-muted"> ~ </span>
                        <span class="price">${{ $book->decimalHighestPrice() }}</span>
                    @else
                        <span class="price">${{ $book->decimalLowestPrice() }}</span>
                    @endif
                </span>
            </div>
        @endif

        {{-- isbn 10 --}}
        <div class="row">
            <span><strong>ISBN-10: </strong></span>
            <span>{{ $book->isbn10 }}</span>
        </div>

        {{-- isbn 13 --}}
        <div class="row padding-bottom-5">
            <span><strong>ISBN-13: </strong></span>
            <span>{{ $book->isbn13 }}</span>
        </div>

        {{-- Status --}}
        <div class="row padding-bottom-5">
            @if($count_product > 0)
                {{-- In stock --}}
                <small class="text-success">
                    <strong>
                        {{ $count_product }}
                        @if($count_product > 1)
                            Books
                        @else
                            Book
                        @endif
                        In Stock
                    </strong>
                </small>
            @else
                {{-- Out of stock --}}
                <small class="text-warning"><strong>Temporarily Out of Stock</strong></small>
            @endif
        </div>
    </div>

    {{-- actions --}}
    <div class="col-sm-2 col-xs-12 hidden-xs">
        <a href="{{ url('textbook/sell/product/'.$book->id.'/create') }}" class="btn btn-sm btn-warning btn-block">Sell</a>
    </div>

    <div class="col-xs-12 visible-xs textbook-actions-xs">
        <a href="{{ url('textbook/sell/product/'.$book->id.'/create') }}" class="btn btn-sm btn-warning">Sell</a>
    </div>

</div>