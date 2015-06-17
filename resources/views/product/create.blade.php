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

                <div class="form-group">
                    <label>{{ $condition['highlights'] }}</label>
                    <input type="number" name="highlights" value="0" class="form-control">
                </div>
                <div class="form-group">
                    <label>{{ $condition['notes'] }}</label>
                    <input type="number" name="notes" value="0" class="form-control">
                </div>
                <div class="form-group">
                    <label>{{ $condition['num_damaged_pages'] }}</label>
                    <input type="number" name="num_damaged_pages" value="0" class="form-control">
                </div>
                <div class="form-group">
                    <label>{{ $condition['broken_spine'] }}</label>
                    <input type="number" name="broken_spine" value="0" class="form-control">
                </div>
                <div class="form-group">
                    <label>{{ $condition['broken_binding'] }}</label>
                    <input type="number" name="broken_binding" value="0" class="form-control">
                </div>
                <div class="form-group">
                    <label>{{ $condition['water_damage'] }}</label>
                    <input type="number" name="water_damage" value="0" class="form-control">
                </div>
                <div class="form-group">
                    <label>{{ $condition['stains'] }}</label>
                    <input type="number" name="stains" value="0" class="form-control">
                </div>
                <div class="form-group">
                    <label>{{ $condition['burns'] }}</label>
                    <input type="number" name="burns" value="0" class="form-control">
                </div>
                <div class="form-group">
                    <label>{{ $condition['rips'] }}</label>
                    <input type="number" name="rips" value="0" class="form-control">
                </div>
                <div class="form-group">
                    <label>{{ $condition['description'] }}</label>
                    <textarea name="description" class="form-control" rows="5" placeholder="{{ $condition['description_placeholder'] }}"></textarea>
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
