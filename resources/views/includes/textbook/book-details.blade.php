<div class="row">
    <?php $count_product = count($book->availableProducts()); ?>

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
                    @if($count_product > 1 && $book->lowest_price != $book->highest_price)
                        <span class="price">${{ $book->lowest_price }}</span>
                        <span class="text-muted"> ~ </span>
                        <span class="price">${{ $book->highest_price }}</span>
                    @else
                        <span class="price">${{ $book->lowest_price }}</span>
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
        <div class="row">
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
                @if(!App\BookReminder::exists($book->id, Auth::id()))
                    <form action="{{ url('textbook/reminder') }}" method="post" class="margin-top-5">
                        {{ csrf_field() }}

                        <input type="hidden" name="book_id" value="{{ $book->id }}">
                        <button type="submit" class="btn btn-xs btn-default">
                            <span class="glyphicon glyphicon-envelope"></span> Remind me when it's available
                        </button>
                    </form>
                @else
                    <br>
                    <a href="#" class="btn btn-xs btn-default disabled margin-top-5">
                        <span class="glyphicon glyphicon-ok"></span> Added to reminder
                    </a>
                @endif
            @endif
        </div>
    </div>

</div>