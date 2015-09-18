@extends('layouts.textbook')

@section('title', 'Search results for '.$query)

@section('searchbar')
    @include('includes.textbook.searchbar')
@endsection

@section('content')

    <div class="container">

        <div class="row">
            <ol class="breadcrumb">
                <li><a href="{{ url('textbook/buy') }}">Home</a></li>
                <li class="active">Search results</li>
            </ol>
        </div>

        <div class="page-header">
            <h1>Books</h1>
        </div>

        @forelse($books as $book)
            {{-- Only show the book if it has product available --}}
            {{-- NOTE: this is not an optimal solution, we could modify our Book query in the back end. --}}
            @if(count($book->availableProducts()) > 0)
                <div class="row padding-vertical-15">

                        <div class="col-md-2 col-xs-4">
                            <a href="{{ url("textbook/buy/".$book->id) }}">
                                <img class="img-responsive" src="{{ $book->imageSet->getImagePath('small') }}">
                            </a>
                        </div>

                        <div class="col-md-10 col-xs-8">
                            <div class="row">
                                <h4 class="no-margin-top">
                                    <a href="{{ url("textbook/buy/".$book->id.'?query=' . Input::get('query')) }}">{{ $book->title }}</a>
                                </h4>
                            </div>

                            <div class="row padding-bottom-5">
                            <span class="text-muted">
                                by
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

                                <span class="text-bold">
                                @if($count_product > 1)
                                        <span class="price">${{ $book->decimalLowestPrice() }}</span>
                                        <span class="text-muted"> ~ </span>
                                        <span class="price">${{ $book->decimalHighestPrice() }}</span>
                                    @else
                                        <span class="price">${{ $book->decimalLowestPrice() }}</span>
                                    @endif
                            </span>

                            <span class="text-muted">
                                @if($count_product > 1)
                                    ({{ $count_product }} offers)
                                @else
                                    (1 offer)
                                @endif
                            </span>
                            </div>

                            <div class="row">
                                <span>ISBN-10: </span>
                                <span>{{ $book->isbn10 }}</span>
                            </div>

                            <div class="row">
                                <span>ISBN-13: </span>
                                <span>{{ $book->isbn13 }}</span>
                            </div>
                        </div>

                </div>
            @endif
        @empty
            <h3 class="text-center">Sorry, there are no search results matching "<i>{{ $query }}</i>."</h3>
        @endforelse

    </div>

    @if (!empty($books))
        <div id="pagination">
            {!! $books->appends(Request::only('query'))->render() !!}
        </div>
    @endif

@endsection

@section('javascript')
    <script src="{{ asset('js/navbar.js') }}"></script>
    <script src="{{ asset('libs/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('js/autocomplete.js')}} "></script>
@endsection
