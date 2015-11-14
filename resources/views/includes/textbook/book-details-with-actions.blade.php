<div class="row">

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

        <div class="row padding-bottom-5">
            <?php $count_product = count($book->availableProducts()); ?>

            @if($count_product > 0)
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

                {{-- # of available products --}}
                <span class="text-muted">
                    @if($count_product > 1)
                        ({{ $count_product }} offers)
                    @else
                        (1 offer)
                    @endif
                </span>
            @else
                <span class="text-warning">Temporarily Out of Stock</span>
            @endif
        </div>

        {{-- isbn 10 --}}
        <div class="row">
            <span><strong>ISBN-10: </strong></span>
            <span>{{ $book->isbn10 }}</span>
        </div>

        {{-- isbn 13 --}}
        <div class="row">
            <span><strong>ISBN-13: </strong></span>
            <span>{{ $book->isbn13 }}</span>
        </div>

        <div class="row">
            <a href="{{ url('textbook/sell/product/'.$book->id.'/create') }}" class="text-warning text-lg">
                <strong>Have one to sell?</strong>
            </a>
        </div>
    </div>

    {{-- actions --}}
    {{--<div class="col-sm-2 hidden-xs text-right">--}}
        {{--<a href="{{ url('textbook/sell/product/'.$book->id.'/create') }}" class="btn btn-default btn-no-border">Sell</a>--}}
    {{--</div>--}}

</div>