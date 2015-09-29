@extends('layouts.admin')

@section('title', 'Book')

@section('content')

    <form action="{{ url('admin/book/' . $book->id) }}" method="post">
        {!! csrf_field() !!}
        <input type="hidden" name="_method" value="PUT" />

        <div class="form-group">
            <label for="">Title</label>
            <input type="text" class="form-control" name="title" value="{{ $book->title }}">
        </div>

        <div class="form-group">
            <label for="">Edition</label>
            <input type="number" class="form-control" name="edition" value="{{ $book->edition }}">
        </div>

        <div class="form-group">
            <label for=""># pages</label>
            <input type="number" class="form-control" name="num_pages" value="{{ $book->num_pages }}">
        </div>

        <div class="form-group">
            <label for="">Language</label>
            <input type="text" class="form-control" name="language" value="{{ $book->language }}">
        </div>

        <div class="form-group">
            <label for="">Verified</label>
            <div class="radio">
                <label>
                    <input type="radio" name="is_verified" value="0" {{ $book->is_verified ? '' : 'checked' }}> No
                </label>
            </div>

            <div class="radio">
                <label>
                    <input type="radio" name="is_verified" value="1" {{ $book->is_verified ? 'checked' : '' }}> Yes
                </label>
            </div>
        </div>

        <input type="submit" value="Update" class="btn btn-primary">
    </form>

@endsection
