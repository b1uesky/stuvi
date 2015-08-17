@extends('admin')

@section('title', 'Book')

@section('content')

    <h1>Books</h1>

    <table class="table table-hover">
        <tr>
            <th>ID</th>
            <th>Cover</th>
            <th>Title</th>
            <th>Edition</th>
            <th>ISBN10</th>
            <th>ISBN13</th>
            <th>Verified</th>
            <th>Actions</th>
        </tr>

        @foreach($books as $book)
            <tr>
                <td>{{ $book->id }}</td>
                <td>
                @if($book->imageSet->small_image)
                    <img class="admin-img-preview" alt="" src="{{ config('aws.url.stuvi-book-img') . $book->imageSet->small_image }}">
                @else
                    <img class="admin-img-preview" alt="" src="{{ config('book.default_image_path.small')}}">
                @endif
                </td>
                <td><a href="{{ URL::to('admin/book/' . $book->id) }}">{{ $book->title }}</a></td>
                <td>{{ $book->edition }}</td>
                <td>{{ $book->isbn10 }}</td>
                <td>{{ $book->isbn13 }}</td>
                <td>{{ $book->is_verified }}</td>
                <td><a class="btn btn-default" role="button" href="{{ URL::to('admin/book/' . $book->id) }}">Details</a></td>
            </tr>
        @endforeach
    </table>
@endsection
