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
                <div class="margin-large border-bottom">
                    <table class="table table-no-border">
                        <tr>
                            <td class="col-xs-2">
                                <a href="{{ url("textbook/buy/".$book->id) }}">
                                    @if($book->imageSet->small_image)
                                        <img class="img-responsive"
                                             src="{{ config('aws.url.stuvi-book-img') . $book->imageSet->small_image }}">
                                    @else
                                        <img class="img-responsive" src="{{ config('book.default_image_path.small')}}">
                                    @endif
                                </a>
                            </td>

                            <td class="col-xs-10">
                                <table class="table-details full-width rel-bot-10">
                                    <tr>
                                        <td class="col-xs-6">
                                            <h4><a href="{{ url("textbook/buy/".$book->id) }}">{{ $book->title }}</a></h4>
                                        </td>
                                        <td class="col-xs-4 text-right">
                                            @if(count($book->products) > 1)
                                                <span class="price">${{ $book->decimalLowestPrice() }}</span>
                                                <span class="text-muted"> ~ </span>
                                                <span class="price">${{ $book->decimalHighestPrice() }}</span>
                                            @else
                                                <span class="price">${{ $book->decimalLowestPrice() }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                </table>

                                <table class="table-details full-width">
                                    <tbody>
                                    <tr>
                                        <th class="col-xs-2">
                                            Author(s):
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

                            </td>
                        </tr>
                    </table>
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
