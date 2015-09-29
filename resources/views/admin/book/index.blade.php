@extends('layouts.admin')

@section('title', 'Book')

@section('content')

    <table class="table table-condensed" data-sortable>
        <thead>
            <tr class="active">
                <th>ID</th>
                <th>Image</th>
                <th>Title</th>
                {{--<th>Edition</th>--}}
                <th>ISBN10</th>
                <th>ISBN13</th>
                {{--<th>Verified</th>--}}
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
        @foreach($books as $book)
            <tr>
                <td>{{ $book->id }}</td>
                <td>
                    <img class="img-small" src="{{ $book->imageSet->getImagePath('small') }}">
                </td>
                <td><a href="{{ url('admin/book/' . $book->id) }}">{{ $book->title }}</a></td>
                {{--<td>{{ $book->edition }}</td>--}}
                <td>{{ $book->isbn10 }}</td>
                <td>{{ $book->isbn13 }}</td>
                {{--<td>{{ $book->is_verified }}</td>--}}
                <td>
                    <a href="{{ url('admin/book/' . $book->id) }}"><span class="glyphicon glyphicon-eye-open"></span></a>
                </td>
            </tr>
        @endforeach
        </tbody>

    </table>

    {!! $books->appends($pagination_params)->render() !!}
@endsection
