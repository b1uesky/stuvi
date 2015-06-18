@extends('textbook')

@section('content')
    <div class="container">
        <div class="row">
            @if($book->imageSet->large_image)
                <img src="{{ $book->imageSet->large_image }}" alt="" />
            @endif

            <div class="">
                Title: {{ $book->title }}
            </div>

            <div class="">
                Edition: {{ $book->edition }}
            </div>

            <div class="">
                ISBN: {{ $book->isbn }}
            </div>

            {{-- Author(s) --}}
            {{-- TODO: Make each author name looks like a tag --}}
            <div class="">
                @if(count($book->authors) > 1)
                    <span>Authors:</span>
                    @foreach($book->authors as $author)
                        <span>{{ $author->full_name }}</span>
                    @endforeach
                @else
                    <span>Author:</span>
                    {{ $book->authors[0]->full_name }}
                @endif
            </div>

            <h2>Book Conditions</h2>

            <form action="/textbook/sell/product/store" method="post" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="book_id" value="{{ $book->id }}"/>
                <input type="hidden" name="book_title" value="{{ $book->title }}">

                {{-- General Condition --}}
                <div class="form-group">
                    <label>{{ $conditions['general_condition']['title'] }}</label>
                    <input type="radio" name="general_condition" value="0" checked> {{ $conditions['general_condition'][0] }}
                    <input type="radio" name="general_condition" value="1"> {{ $conditions['general_condition'][1] }}
                    <input type="radio" name="general_condition" value="2"> {{ $conditions['general_condition'][2] }}
                    <input type="radio" name="general_condition" value="3"> {{ $conditions['general_condition'][3] }}
                </div>

                {{-- Highlights/Notes --}}
                <div class="form-group">
                    <label>{{ $conditions['highlights_and_notes']['title'] }}</label>
                    <input type="radio" name="highlights_and_notes" value="0" checked> {{ $conditions['highlights_and_notes'][0] }}
                    <input type="radio" name="highlights_and_notes" value="1"> {{ $conditions['highlights_and_notes'][1] }}
                    <input type="radio" name="highlights_and_notes" value="2"> {{ $conditions['highlights_and_notes'][2] }}
                </div>

                {{-- Damaged Pages --}}
                <div class="form-group">
                    <label>{{ $conditions['damaged_pages']['title'] }}</label>
                    <input type="radio" name="damaged_pages" value="0" checked> {{ $conditions['damaged_pages'][0] }}
                    <input type="radio" name="damaged_pages" value="1"> {{ $conditions['damaged_pages'][1] }}
                    <input type="radio" name="damaged_pages" value="2"> {{ $conditions['damaged_pages'][2] }}
                </div>

                {{-- Broken Binding --}}
                <div class="form-group">
                    <label>{{ $conditions['broken_binding']['title'] }}</label>
                    <input type="radio" name="broken_binding" value="0" checked> {{ $conditions['broken_binding'][0] }}
                    <input type="radio" name="broken_binding" value="1"> {{ $conditions['broken_binding'][1] }}
                </div>

                {{-- Description --}}
                <div class="form-group">
                    <label>{{ $conditions['description']['title'] }}</label>
                    <textarea name="description" class="form-control" rows="5" placeholder="{{ $conditions['description']['placeholder'] }}"></textarea>
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
