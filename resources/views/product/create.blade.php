@extends('textbook')

@section('content')
    <head>
        <link href="{{ asset('/css/product-create.css') }}" rel="stylesheet">
        <title>Enter book info</title>
    </head>

    <div class="container">
        <div class="row textbook-row">
            <div class="col-sm-6">
                @if($book->imageSet->large_image)
                    <img id="textbook-img" src="{{ $book->imageSet->large_image }}" alt=""/>
                @endif
            </div>

            <div class="col-sm-6 textbook-info">
                <h1>{{ $book->title }}</h1>

                <div class="authors-container">
                    <span>by </span>
                    @foreach($book->authors as $author)
                        <span id="authors"><button class="btn btn-default author-btn">{{ $author->full_name }}</button></span>
                    @endforeach
                </div>
                <p>ISBN: {{ $book->isbn }}</p>

                <p>Edition: {{ $book->edition }}</p>

                <p>Number of Pages: {{ $book->num_pages }}</p>
            </div>
        </div>
        <div class="row">
            {{--@if($book->imageSet->large_image)--}}
            {{--<img src="{{ $book->imageSet->large_image }}" alt="" />--}}
            {{--@endif--}}

            {{--<div class="">--}}
            {{--Title: {{ $book->title }}--}}
            {{--</div>--}}

            {{--<div class="">--}}
            {{--Edition: {{ $book->edition }}--}}
            {{--</div>--}}

            {{--<div class="">--}}
            {{--ISBN: {{ $book->isbn }}--}}
            {{--</div>--}}

            {{-- Author(s) --}}
            {{-- TODO: Make each author name looks like a tag --}}
            {{--<div class="">--}}
            {{--@if(count($book->authors) > 1)--}}
            {{--<span>Authors:</span>--}}
            {{--@foreach($book->authors as $author)--}}
            {{--<span>{{ $author->full_name }}</span>--}}
            {{--@endforeach--}}
            {{--@else--}}
            {{--<span>Author:</span>--}}
            {{--{{ $book->authors[0]->full_name }}--}}
            {{--@endif--}}
            {{--</div>--}}

            <h2>Book Conditions</h2>

            <form action="/textbook/sell/product/store" method="post" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="book_id" value="{{ $book->id }}"/>
                <input type="hidden" name="book_title" value="{{ $book->title }}">

                <div class="form-group">
                    <label>Choose one:</label>

                    <div>
                        <button type="button" class="btn btn-default condition-btn">Brand New</button>
                        <button type="button" class="btn btn-default condition-btn">Excellent</button>
                        <button type="button" class="btn btn-default condition-btn">Good</button>
                        <button type="button" class="btn btn-default condition-btn">Acceptable</button>
                    </div>
                </div>

                <div class="form-group">
                    <label>Highlights/Notes</label>

                    <div class="switch">
                        <input id="toggle-condition-1" class="form-control toggle toggle-yes-no" type="checkbox"
                               name="highlights">
                        <label for="toggle-condition-1" data-on="Yes" data-off="No"></label>
                    </div>
                    {{--<input type="number" name="highlights" value="0" class="form-control">--}}
                </div>
                <div class="form-group">
                    <label>{{ $conditions['notes'] }}</label>

                    <div class="switch">
                        <input id="toggle-condition-2" class="form-control toggle toggle-yes-no" type="checkbox"
                               name="notes">
                        <label for="toggle-condition-2" data-on="Yes" data-off="No"></label>
                    </div>
                    {{--<input type="number" name="notes" value="0" class="form-control">--}}
                </div>
                <div class="form-group">
                    <label>{{ $conditions['num_damaged_pages'] }}</label>

                    <div class="switch">
                        <input id="toggle-condition-3" class="form-control toggle toggle-yes-no" type="checkbox"
                               name="num_damaged_pages">
                        <label for="toggle-condition-3" data-on="Yes" data-off="No"></label>
                    </div>
                    {{--<input type="number" name="num_damaged_pages" value="0" class="form-control">--}}
                </div>
                <div class="form-group">
                    <label>{{ $conditions['broken_spine'] }}</label>

                    <div class="switch">
                        <input id="toggle-condition-4" class="form-control toggle toggle-yes-no" type="checkbox"
                               name="broken_spine">
                        <label for="toggle-condition-4d" data-on="Yes" data-off="No"></label>
                    </div>
                    {{--<input type="number" name="broken_spine" value="0" class="form-control">--}}
                </div>
                <div class="form-group">
                    <label>{{ $conditions['broken_binding'] }}</label>
                    <input type="number" name="broken_binding" value="0" class="form-control">
                </div>
                <div class="form-group">
                    <label>{{ $conditions['water_damage'] }}</label>
                    <input type="number" name="water_damage" value="0" class="form-control">
                </div>
                <div class="form-group">
                    <label>{{ $conditions['stains'] }}</label>
                    <input type="number" name="stains" value="0" class="form-control">
                </div>
                <div class="form-group">
                    <label>{{ $conditions['burns'] }}</label>
                    <input type="number" name="burns" value="0" class="form-control">
                </div>
                <div class="form-group">
                    <label>{{ $conditions['rips'] }}</label>
                    <input type="number" name="rips" value="0" class="form-control">
                </div>
                <div class="form-group">
                    <label>{{ $conditions['description'] }}</label>
                    <textarea name="description" class="form-control" rows="5" placeholder="{{ $conditions['description_placeholder'] }}"></textarea>
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
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/product-create.js') }}"></script>
@endsection
