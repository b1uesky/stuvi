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

            </div>
        </div>
        <div class="row">
            <h2>Book Conditions</h2>

            <form action="/textbook/sell/product/store" method="post" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="book_id" value="{{ $book->id }}"/>
                <input type="hidden" name="book_title" value="{{ $book->title }}">

                {{-- General Condition --}}
                <div class="form-group">
                    <label>{{ $conditions['general_condition']['title'] }}</label>
                    <br>

                    <div class="btn-group" data-toggle="buttons">
                        <label class="btn btn-default condition-btn">
                            <input type="radio" name="general_condition"
                                   value="0"> {{ $conditions['general_condition'][0] }}
                        </label>
                        <label class="btn btn-default condition-btn">
                            <input type="radio" name="general_condition"
                                   value="1"> {{ $conditions['general_condition'][1] }}
                        </label>
                        <label class="btn btn-default condition-btn">
                            <input type="radio" name="general_condition"
                                   value="2"> {{ $conditions['general_condition'][2] }}
                        </label>
                        <label class="btn btn-default condition-btn">
                            <input type="radio" name="general_condition"
                                   value="3"> {{ $conditions['general_condition'][3] }}
                        </label>
                    </div>
                </div>

                {{-- Highlights/Notes --}}
                <div class="form-group">
                    <label>{{ $conditions['highlights_and_notes']['title'] }}</label>
                    <br>

                    <div class="btn-group" data-toggle="buttons">
                        <label class="btn btn-default condition-btn">
                            <input type="radio" name="general_condition"
                                   value="0"> {{ $conditions['highlights_and_notes'][0] }}
                        </label>
                        <label class="btn btn-default condition-btn">
                            <input type="radio" name="general_condition"
                                   value="1"> {{ $conditions['highlights_and_notes'][1] }}
                        </label>
                        <label class="btn btn-default condition-btn">
                            <input type="radio" name="general_condition"
                                   value="2"> {{ $conditions['highlights_and_notes'][2] }}
                        </label>
                    </div>
                </div>

                {{-- Damaged Pages --}}
                <div class="form-group">
                    <label>{{ $conditions['damaged_pages']['title'] }}</label>
                    <br>

                    <div class="btn-group" data-toggle="buttons">
                        <label class="btn btn-default condition-btn">
                            <input type="radio" name="general_condition"
                                   value="0"> {{ $conditions['damaged_pages'][0] }}
                        </label>
                        <label class="btn btn-default condition-btn">
                            <input type="radio" name="general_condition"
                                   value="1"> {{ $conditions['damaged_pages'][1] }}
                        </label>
                        <label class="btn btn-default condition-btn">
                            <input type="radio" name="general_condition"
                                   value="2"> {{ $conditions['damaged_pages'][2] }}
                        </label>
                    </div>
                </div>

                {{-- Broken Binding --}}
                <div class="form-group">
                    <label>{{ $conditions['broken_binding']['title'] }}</label>
                    <br>

                    <div class="btn-group" data-toggle="buttons">
                        <label class="btn btn-default condition-btn">
                            <input type="radio" name="general_condition"
                                   value="0"> {{ $conditions['broken_binding'][0] }}
                        </label>
                        <label class="btn btn-default condition-btn">
                            <input type="radio" name="general_condition"
                                   value="1"> {{ $conditions['broken_binding'][1] }}
                        </label>
                    </div>
                </div>

                {{-- Description --}}
                <div class="form-group">
                    <label>{{ $conditions['description']['title'] }}</label>
                    <textarea name="description" class="form-control" rows="5"
                              placeholder="{{ $conditions['description']['placeholder'] }}"></textarea>
                </div>

                {{-- Price --}}
                <div class="form-group">
                    <label>Price</label>
                    <input type="number" step="0.01" name="price" class="form-control">
                </div>

                {{-- Upload Images --}}
                <div class="form-group">
                    <label>Upload images</label>
                    <input type="file" name="images[]" multiple>
                </div>
                <input type="submit" name="submit" class="btn btn-primary" value="submit"/>
            </form>
        </div>
    </div>
@endsection
