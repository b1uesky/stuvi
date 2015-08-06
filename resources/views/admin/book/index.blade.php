@extends('admin')

@section('title', 'Book')

@section('content')
    <table class="table table-hover">
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Edition</th>
            <th>ISBN10</th>
            <th>ISBN13</th>
            <th>Number of Pages</th>
            <th>Verified</th>
            <th>Language</th>
            <th>Created At</th>
            <th>Actions</th>
        </tr>

        @foreach($books as $book)
            <tr>
                <td>{{ $book->id }}</td>
                <td>{{ $book->title }}</td>
                <td>{{ $book->edition }}</td>
                <td>{{ $book->isbn10 }}</td>
                <td>{{ $book->isbn13 }}</td>
                <td>{{ $book->num_pages }}</td>
                <td>{{ $book->is_verified }}</td>
                <td>{{ $book->language }}</td>
                <td>{{ $book->created_at }}</td>
                <td><a class="btn btn-default" role="button" href="{{ URL::to('admin/book/' . $book->id) }}">Details</a></td>
            </tr>
        @endforeach
    </table>
@endsection
