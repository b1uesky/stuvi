@extends('layouts.admin')

@section('title', 'Book')

@section('content')

    <form class="form-inline" role="form" action="{{ url('admin/book') }}" method="get">
        <div class="form-group">
            <select name="filter" class="form-control">
                <option value="id" @if ($pagination_params['filter'] == 'id') selected @endif>ID</option>
                <option value="title" @if ($pagination_params['filter'] == 'title') selected @endif>Title</option>
                <option value="isbn" @if ($pagination_params['filter'] == 'isbn') selected @endif>ISBN</option>
            </select>
        </div> <!-- form group [rows] -->
        <div class="form-group">
            <input type="text" class="form-control" name="keyword" value="{{ $pagination_params['keyword'] }}">
        </div><!-- form group [search] -->
        <div class="form-group">
            <label class="filter-col">Order by:</label>
            <select name="order_by" class="form-control">
                <option value="id" @if ($pagination_params['order_by'] == 'id') selected @endif>ID</option>
                <option value="title" @if ($pagination_params['order_by'] == 'title') selected @endif>Title</option>
                <option value="isbn10" @if ($pagination_params['order_by'] == 'isbn10') selected @endif>ISBN-10</option>
                <option value="isbn13" @if ($pagination_params['order_by'] == 'isbn13') selected @endif>ISBN-13</option>
                <option value="created_at" @if ($pagination_params['order_by'] == 'created_at') selected @endif>Created At</option>
                <option value="updated_at" @if ($pagination_params['order_by'] == 'updated_at') selected @endif>Updated At</option>
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

    <br>

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
                    <img class="img-responsive" src="{{ $book->imageSet->getImagePath('small') }}">
                </td>
                <td><a href="{{ url('admin/book/' . $book->id) }}">{{ $book->title }}</a></td>
                {{--<td>{{ $book->edition }}</td>--}}
                <td>{{ $book->isbn10 }}</td>
                <td>{{ $book->isbn13 }}</td>
                {{--<td>{{ $book->is_verified }}</td>--}}
                <td><a class="btn btn-primary btn-block" role="button" href="{{ url('admin/book/' . $book->id) }}">Details</a></td>
            </tr>
        @endforeach
        </tbody>

    </table>

    {!! $books->appends($pagination_params)->render() !!}
@endsection
