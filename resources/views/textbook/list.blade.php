@extends('textbook')

@section('content')
    <head>
        <link href="{{ asset('/css/textbook/textbook-list.css') }}" rel="stylesheet">
        <title>Search Results</title>
    </head>

    @include('textbook/textbook-nav')

    <div class="container-fluid textbook-list-container">
        @if(trim($info) != "")
            <h1 id="search-term">Search results for "{{ $info }}"</h1>
        @else
            <h1 id="search-term">Search results</h1>
        @endif
        <div class="container">
            <span class="text-muted">Sort by</span>
            <ul class="nav nav-pills">
                <li role="presentation" class="active"><a href="#" data-toggle="pill">Title</a></li>
                <li role="presentation"><a href="#" data-toggle="pill">Author</a></li>
                <li role="presentation"><a href="#" data-toggle="pill">Most Bought</a></li>
                <li role="presentation"><a href="#" data-toggle="pill">Top Rated</a></li>

                <div class="col-sm-4 col-md-4 pull-right">
                    <form action="/textbook/buy/search" method="post" class="navbar-form" role="search">
                        <div class="input-group">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="text" class="form-control" placeholder="Search" name="info">

                            <div class="input-group-btn">
                                <button class="btn btn-default search-btn" type="submit" name="search" value="Search">
                                    <i class="fa fa-search search-icon"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </ul>
        </div>

        <div class="container textbook-list">
            <table class="table table-responsive textbook-table">
                <!-- new row for each book -->
                @forelse($books as $book)
                    <tr class="textbook-item">
                        <td class="textbook-img-container">
                            <a href="{{ url("textbook/buy/textbook/".$book->id) }}">
                                <img class="textbook-img" src="{{ $book->imageSet->medium_image }}">
                            </a>
                        </td>
                        <td class="textbook-info-1">
                            <span class="textbook-title"><a
                                        href="{{ url("textbook/buy/textbook/".$book->id) }}">{{ $book->title }}</a></span><br>
                            @if(count($book->authors) > 1)
                                <span>Authors:</span>
                                @foreach($book->authors as $author)
                                    <span>{{ $author->full_name }}</span>
                                @endforeach
                            @else
                                <span>Author:</span>
                                {{ $book->authors[0]->full_name }}
                            @endif
                            <br>
                            <span class="textbook-isbn">ISBN10: {{ $book->isbn10 }}</span>
                            <br>
                            <span class="textbook-isbn">ISBN13: {{ $book->isbn13 }}</span>
                            <br>
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
                    <p class="empty">Sorry, there are no search results matching "<i>{{ $info }}</i>."</p>
                @endforelse
            </table>
        </div>
    </div>
@endsection
