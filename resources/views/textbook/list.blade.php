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
                @include('includes.textbook.book-details')
                <br>
            @endif
        @empty
            <h3 class="text-center">Sorry, there are no search results matching "<i>{{ $query }}</i>."</h3>
        @endforelse

    </div>

    @if (!empty($books))
        <div id="pagination">
            {!! $books->appends(Request::only('query', 'university_id'))->render() !!}
        </div>
    @endif

@endsection

@section('javascript')
    <script src="{{ asset('libs/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('js/autocomplete.js')}} "></script>
@endsection
