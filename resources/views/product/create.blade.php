@extends('textbook')

@section('content')
    <div class="container">
        <div class="row">
            <div>
                @if(!empty($image))
                    <img src="{{ $image->large_image }}" alt="" />
                @endif

                <p>Title:  {{ $book->title }}</p>
                <p>edition {{ $book->edition }}th</p>
                <p>Author: {{ $book->author }}</p>
                <p>isbn:   {{ $book->isbn }}</p>
            </div>

            <form action="/textbook/sell/product/store" method="post" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="book_id" value="{{ $book->id }}"/>
                <input type="hidden" name="book_title" value="{{ $book->title }}">

                <div class="form-group">
                    <label>Highlights</label>
                    <input type="number" name="highlights" value="0" class="form-control">
                </div>
                <div class="form-group">
                    <label>Notes</label>
                    <input type="number" name="notes" value="0" class="form-control">
                </div>
                <div class="form-group">
                    <label>Number of missing, torn, or loose pages</label>
                    <input type="number" name="num_damaged_pages" value="0" class="form-control">
                </div>
                <div class="form-group">
                    <label>Broken book spine</label>
                    <input type="number" name="broken_spine" value="0" class="form-control">
                </div>
                <div class="form-group">
                    <label>Broken book binding</label>
                    <input type="number" name="broken_binding" value="0" class="form-control">
                </div>
                <div class="form-group">
                    <label>Water damage</label>
                    <input type="number" name="water_damage" value="0" class="form-control">
                </div>
                <div class="form-group">
                    <label>Stains</label>
                    <input type="number" name="stains" value="0" class="form-control">
                </div>
                <div class="form-group">
                    <label>Burns</label>
                    <input type="number" name="burns" value="0" class="form-control">
                </div>
                <div class="form-group">
                    <label>Rips</label>
                    <input type="number" name="rips" value="0" class="form-control">
                </div>
                <div class="form-group">
                    <label>Price</label>
                    <input type="number" step="0.01" name="price" class="form-control">
                </div>
                <div class="form-group">
                    <label>Upload images</label>
                    <input type="file" name="images[]" multiple>
                </div>
                <input type="submit" name="submit" class="btn btn-primary" value="submit"/>
            </form>
        </div>
    </div>
@endsection
