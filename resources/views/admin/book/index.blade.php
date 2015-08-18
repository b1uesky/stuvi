@extends('admin')

@section('title', 'Book')

@section('content')

    <h1>Books</h1>

    <form class="form-inline" role="form" action="{{ url('admin/book') }}" method="get">
        <div class="form-group">
            <select name="filter" class="form-control">
                <option value="id">ID</option>
                <option value="title">Title</option>
                <option value="isbn" selected>ISBN</option>
            </select>
        </div> <!-- form group [rows] -->
        <div class="form-group">
            <input type="text" class="form-control input-large" name="keyword">
        </div><!-- form group [search] -->
        <div class="form-group">
            <label class="filter-col" style="margin-right:0;">Order by:</label>
            <select name="order_by" class="form-control">
                <option value="id" selected>ID</option>
                <option value="title">Title</option>
                <option value="isbn10">ISBN-10</option>
                <option value="isbn13">ISBN-13</option>
                <option value="created_at">Created At</option>
                <option value="updated_at">Updated At</option>
            </select>
        </div> <!-- form group [rows] -->
        <div class="form-group">
            <select name="order" class="form-control">
                <option value="DESC" selected>DESC</option>
                <option value="ASC">ASC</option>
            </select>
        </div> <!-- form group [rows] -->
        <div class="form-group">
            <button type="submit" class="btn btn-default filter-col">
                Search
            </button>
        </div>
    </form>

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

    {!! $books->render() !!}
@endsection
