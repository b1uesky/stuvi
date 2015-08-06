@extends('app')

@section('title', 'Search results for '.$query)

@section('css')
    <link href="{{ asset('/css/textbook_list.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
@endsection

{{--@section('searchbar')--}}
    {{--@include('includes.textbook.searchbar')--}}
{{--@endsection--}}

@section('content')

    @include('textbook/textbook-nav')

    <div class="container-fluid textbook-list-container">
        @if(trim($query) != "")
            <h1 id="search-term">Search results for "{{ $query }}"</h1>
        @else
            <h1 id="search-term">Search results</h1>
        @endif
        <div class="container">
            {{--<span class="text-muted">Sort by</span>--}}
            <ul class="nav nav-pills">
                {{--<li role="presentation" class="active"><a href="#" data-toggle="pill">Title</a></li>--}}
                {{--<li role="presentation"><a href="#" data-toggle="pill">Author</a></li>--}}
                {{--<li role="presentation"><a href="#" data-toggle="pill">Most Bought</a></li>--}}
                {{--<li role="presentation"><a href="#" data-toggle="pill">Top Rated</a></li>--}}

            </ul>
        </div>

        <div class="container textbook-list">
            <table class="table table-responsive textbook-table">
                <!-- new row for each book -->
                @forelse($books as $book)
                    <tr class="textbook-item">
                        <td class="textbook-img-container">
                            <a href="{{ url("textbook/buy/".$book->id) }}">

                                <img class="textbook-img"
                                     src="{{ $book->imageSet->small_image or config('book.default_image_path.large')}}">
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
                                From <span class="textbook-low-price">${{ $book->decimalLowestPrice() }}</span>
                                to <span class="textbook-high-price">${{ $book->decimalHighestPrice() }}</span>
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
    {{--<script src="{{ asset('libs/jquery-ui/jquery-ui.min.js') }}"></script>--}}
    {{--<script src="{{ asset('/js/autocomplete.js')}} "></script>--}}
@endsection
