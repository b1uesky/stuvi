@extends('textbook')

@section('content')
    <div class="container">
        <div class="row">
            <div>
                <p>Title:  {{ $book->title }}</p></br>
                <p>edition {{ $book->edition }}th</p></br>
                <p>Author: {{ $book->author }}</p></br>
                <p>isbn:   {{ $book->isbn }}</p></br>
            </div>

            <form action="/textbook/sell/product/store" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="book_id" value="{{ $book->id }}"/>

                <div class="form-group">
                    <label>Highlights</label>
                    <input type="number" name="highlights" class="form-control">
                </div>
                <div class="form-group">
                    <label>Notes</label>
                    <input type="number" name="notes" class="form-control">
                </div>
                <div class="form-group">
                    <label>Number of missing, torn, or loose pages</label>
                    <input type="number" name="num_damaged_pages" class="form-control">
                </div>
                <div class="form-group">
                    <label>Broken book spine</label>
                    <input type="number" name="broken_spine" class="form-control">
                </div>
                <div class="form-group">
                    <label>Broken book binding</label>
                    <input type="number" name="broken_binding" class="form-control">
                </div>
                <div class="form-group">
                    <label>Water damage</label>
                    <input type="number" name="water_damage" class="form-control">
                </div>
                <div class="form-group">
                    <label>Stains</label>
                    <input type="number" name="stains" class="form-control">
                </div>
                <div class="form-group">
                    <label>Burns</label>
                    <input type="number" name="burns" class="form-control">
                </div>
                <div class="form-group">
                    <label>Rips</label>
                    <input type="number" name="rips" class="form-control">
                </div>
                <div class="form-group">
                    <label>Price</label>
                    <input type="number" step="0.01" name="price" class="form-control">
                </div>
                <input type="submit" name="submit" class="btn btn-primary" value="submit"/>
            </form>
        </div>
    </div>
@endsection