{{-- Page for creating a new textbook --}}


@extends('layouts.textbook')

@section('title', 'Create a textbook')

@section('content')

<!-- top container..determines background -->
<div class = "container-fluid create">
    <!-- center the forms -->
    <div class="container col-md-8 col-md-offset-2 pad">
        <div class="row">

            <h1 id="create-title">Enter your textbook information</h1>
            <!-- form begin -->
            <form action="/textbook/sell/store" method="post" class="form textbook-create" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <!-- ISBN -->
                <div class="form-group">
                    <label><b>ISBN (10 or 13)</b></label>
                    <input type="string" name="isbn" value="{{ Input::old('isbn') }}" class="form-control"/>
                </div>
                <!-- Title -->
                <div class="form-group">
                    <label><b>Title</b></label>
                    <input type="text" name="title" value="{{ Input::old('title') }}" class="form-control"/>
                </div>
                <!-- Authors -->
                <div class="form-group">
                    <label><b>Author(s)</b></label>
                    <small>Seperate authors by ,</small>
                    <input type="text" name="authors" value="{{ Input::old('authors') }}" class="form-control"/>
                </div>
                <!-- Edition -->
                <div class="form-group">
                    <label><b>Edition</b></label>
                    <input type="number" name="edition" value="{{ Input::old('edition') or 1 }}" class="form-control" min="1" step="1"/>
                </div>
                <!-- Num pg -->
                <div class="form-group">
                    <label><b>Number of Pages</b></label>
                    <input type="number" name="num_pages" value="{{ Input::old('num_pages') }}" class="form-control" min="1" step="1"/>
                </div>
                <!-- Select Language -->
                <!-- TODO: a complete list of languages -->
                <div class="form-group">
                    <label><b>Language</b></label>
                    <select class="selectpicker textbook-create form-control" name="language" id="lang">
                        @foreach(config('book.languages') as $key => $value)
                            <option value="{{ $value }}" class="lang-select">{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
                {{-- Upload Images --}}
                <div class="form-group" name="cover_img">
                    <label>Front cover image (smaller than 3MB)</label>
                    <input type="file" name="image" class="upload-file"/>
                </div>

                <input type="submit" name="submit" class="btn btn-primary create-btn" id="create-btn" value="Submit"/>
            </form>
        </div> <!-- End row -->
    </div> <!-- end container -->
</div> <!-- End fluid container (background) -->

@endsection

@section('javascript')
@endsection
