@extends('layouts.textbook')

@section('title', 'Search results for '.$query)

@section('searchbar')
    @include('includes.textbook.searchbar')
@endsection

@section('content')

    @include('textbook/textbook-nav')

    <div class="container-fluid textbook-list-container">

        <div class="container">
            <div class="page-header">
                <h1>Books</h1>
            </div>

            @forelse($books as $book)
                <div class="row padding-15 border-bottom">
                    <div class="col-md-2 col-sm-2 col-xs-4">
                        <a href="{{ url("textbook/buy/".$book->id) }}">
                            @if($book->imageSet->small_image)
                                <img class="img-responsive"
                                     src="{{ config('aws.url.stuvi-book-img') . $book->imageSet->small_image }}">
                            @else
                                <img class="img-responsive" src="{{ config('book.default_image_path.small')}}">
                            @endif
                        </a>
                    </div>

                    <div class="col-md-8 col-sm-7 col-xs-8">
                        <h4 class="col-sm-12 no-margin-top"><a href="{{ url("textbook/buy/".$book->id) }}">{{ $book->title }}</a></h4>

                        <table class="table-details full-width">
                            <tbody>
                            <tr>
                                <th class="col-xs-2">
                                    <span>Author(s):</span>
                                </th>
                                <td class="col-xs-10">
                                    @foreach($book->authors as $i => $author)
                                        @if($i == 0)
                                            <span>{{ $author->full_name }}</span>
                                        @else
                                            <span>, {{ $author->full_name }}</span>
                                        @endif
                                    @endforeach
                                </td>
                            </tr>

                            <tr>
                                <th class="col-xs-2">ISBN-10:</th>
                                <td class="col-xs-10">{{ $book->isbn10 }}</td>
                            </tr>

                            <tr>
                                <th class="col-xs-2">ISBN-13:</th>
                                <td class="col-xs-10">{{ $book->isbn13 }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="col-md-2 col-sm-3 hidden-xs">
                        @if(count($book->products) > 1)
                            <span class="price">${{ $book->decimalLowestPrice() }}</span>
                            <span class="text-muted"> ~ </span>
                            <span class="price">${{ $book->decimalHighestPrice() }}</span>
                        @elseif(count($book->products) == 1)
                            <span class="price">${{ $book->decimalLowestPrice() }}</span>
                        @else
                            <span class="text-muted">Not available</span>
                        @endif
                    </div>
                </div>

                @empty
                    <h3 class="text-center">Sorry, there are no search results matching "<i>{{ $query }}</i>."</h3>
                @endforelse

        </div>


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
