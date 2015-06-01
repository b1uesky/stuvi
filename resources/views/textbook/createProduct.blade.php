@extends('textbook')

@section('content')
    <div>
        <p>Title:  {{ $book->title }}</p></br>
        <p>edition {{ $book->edition }}th</p></br>
        <p>Author: {{ $book->author }}</p></br>
        <p>isbn:   {{ $book->isbn }}</p></br>
    </div>
    <div class="container">
        <div class="row">
            <form action="/textbook/sell/storeProduct" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group">
                    <input type="number" name="price" class="form-control">Price</input>
                </div>
                <input type="submit" name="Add" class="btn btn-primary" value="Add"/>
            </form>
        </div>
    </div>
@endsection