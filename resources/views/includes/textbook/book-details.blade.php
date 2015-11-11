<div class="row">

    {{-- book image --}}
    <div class="col-md-2 col-xs-4">
        <a href="{{ url("textbook/buy/".$book->id) }}">
            <img class="img-responsive" src="{{ $book->imageSet->getImagePath('small') }}">
        </a>
    </div>

    {{-- book details --}}
    <div class="col-md-10 col-xs-8">

        {{-- title --}}
        <div class="row">
            <h4 class="no-margin-top">
                @if(Auth::check())
                    <a href="{{ url("textbook/buy/".$book->id.'?query=' . Input::get('query')) }}">{{ $book->title }}</a>
                @else
                    <a href="{{ url("textbook/buy/".$book->id.'?query=' . Input::get('query') . '&university_id=' . Input::get('university_id')) }}">{{ $book->title }}</a>
                @endif
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
            <span>ISBN-10: </span>
            <span>{{ $book->isbn10 }}</span>
        </div>

        {{-- isbn 13 --}}
        <div class="row">
            <span>ISBN-13: </span>
            <span>{{ $book->isbn13 }}</span>
        </div>
    </div>

</div>