@extends('layouts.textbook')

@section('title', 'Search results for '.$query)

@section('css')
    <link href="{{ asset('/css/textbook_list.css') }}" rel="stylesheet">
@endsection

@section('searchbar')
    @include('includes.textbook.searchbar')
@endsection

@section('content')

    @include('textbook/textbook-nav')

    <div class="container-fluid textbook-list-container">

        <div class="container textbook-list">
            {{-- HEADER --}}
            <div class="textbook-list-header">
                <h2 class="textbook-list-title">Books</h2>

                @if(trim($query) != "")
                    <div class="textbook-list-results">
                        {{ count($books) }} results for {{ $query }}
                    </div>
                @else
                    <div class="textbook-list-results">
                        {{ count($books) }} results
                    </div>
                @endif
            </div>

            <table class="table table-responsive textbook-table">
                <!-- new row for each book -->
                @forelse($books as $book)
                    <tr class="textbook-item">
                        <td class="textbook-img-container">
                            <a href="{{ url("textbook/buy/".$book->id) }}">

                                @if($book->imageSet->small_image)
                                    <img class="textbook-img" src="{{ config('aws.url.stuvi-book-img') . $book->imageSet->small_image }}">
                                @else
                                    <img class="textbook-img" src="{{ config('book.default_image_path.small')}}">
                                @endif
                            </a>
                        </td>
                        <td class="textbook-info-1">
                            <span class="textbook-title"><a href="{{ url("textbook/buy/".$book->id) }}">{{ $book->title }}</a></span><br>

                            @if($book->authors->count())
                                <span>Author(s):</span>
                                <?php $i = 0; ?>
                                @foreach($book->authors as $author)
                                    @if($i == 0)
                                        <span>{{ $author->full_name }}</span>
                                        <?php $i++ ?>
                                    @else
                                        <span>, {{ $author->full_name }}</span>
                                    @endif
                                @endforeach
                            @endif

                            <br>
                            <span class="textbook-isbn">ISBN10: {{ $book->isbn10 }}</span>
                            <br>
                            <span class="textbook-isbn">ISBN13: {{ $book->isbn13 }}</span>
                            <br>
                            <br>

                            <span>
                                @if(count($book->products) > 1)
                                    From <span class="textbook-price">${{ $book->decimalLowestPrice() }}</span>
                                    to <span class="textbook-price">${{ $book->decimalHighestPrice() }}</span>
                                @else
                                    <span class="textbook-price">${{ $book->decimalLowestPrice() }}</span>
                                @endif
                            </span>
                        </td>
                        <td class="table-offset"></td>
                        <td class="textbook-info-2">
                            <!-- each class the book support -->
                            {{--<h5>Classes</h5>--}}
                            {{--<span class="textbook-class"><a href="#">BU:SMG SM131</a></span>--}}
                        </td>
                    </tr>
                @empty
                    <br>
                    <p class="empty">Sorry, there are no search results matching "<i>{{ $query }}</i>."</p>
                @endforelse
            </table>
        </div>
            <div id="pagination">
            {!! $books->appends(Request::only('query'))->render() !!}
            </div>

    </div>
@endsection

@section('javascript')
    <script src="{{ asset('js/navbar.js') }}"></script>
    <script src="{{ asset('libs/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('js/autocomplete.js')}} "></script>
@endsection
