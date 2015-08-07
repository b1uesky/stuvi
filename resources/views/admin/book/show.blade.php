@extends('admin')

@section('title', 'Book')

@section('content')

    {{--{{ dd($book) }}--}}

    <table class="table table-hover">
        <tr>
            <th>ID</th>
            <td>{{ $book->id }}</td>
        </tr>
        <tr>
            <th>Title</th>
            <td>{{ $book->title }}</td>
        </tr>
        <tr>
            <th>Edition</th>
            <td>{{ $book->edition }}</td>
        </tr>
        <tr>
            <th>ISBN10</th>
            <td>{{ $book->isbn10 }}</td>
        </tr>
        <tr>
            <th>ISBN13</th>
            <td>{{ $book->isbn13 }}</td>
        </tr>
        <tr>
            <th>Number of Pages</th>
            <td>{{ $book->num_pages }}</td>
        </tr>
        <tr>
            <th>Verified</th>
            <td>{{ $book->is_verified }}</td>
        </tr>
        <tr>
            <th>Language</th>
            <td>{{ $book->language }}</td>
        </tr>
        <tr>
            <th>List Price</th>
            <td>{{ $book->list_price }}</td>
        </tr>
        <tr>
            <th>Created At</th>
            <td>{{ $book->created_at }}</td>
        </tr>
    </table>

@endsection
