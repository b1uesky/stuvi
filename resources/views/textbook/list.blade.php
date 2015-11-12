@extends('layouts.textbook')

@section('title', 'Search results for '.$query)

@section('content')

    <div class="container">

        <div class="row">
            <ol class="breadcrumb">
                <li><a href="{{ url('/') }}">Home</a></li>
                <li class="active">Search results</li>
            </ol>
        </div>

        <div class="page-header">
            <h1>Textbooks</h1>
        </div>

        @forelse($books as $book)
            @include('includes.textbook.book-details-with-actions')
            <hr>
        @empty
            <h4 class="text-center">Sorry, we can't find <span class="text-primary">{{ $query }}</span>... Please double check the ISBN or spelling.</h4>
        @endforelse

    </div>

    @if (!empty($books))
        <div id="pagination">
            {!! $books->appends(Request::only('query', 'university_id'))->render() !!}
        </div>
    @endif

@endsection
