@extends('textbook')

@section('content')
    @foreach($books as $book)
        <div>{{ $book->title }}</div>
    @endforeach
@endsection