{{-- Page for creating a new textbook --}}


@extends('textbook')
    <head>
        <title>Stuvi - Create textbook</title>
        <link href="{{ asset('/css/create.css') }}" rel="stylesheet">
    </head>

@section('content')


<!-- top container..determines background -->
<div class = "container-fluid create">
    <!-- center the forms -->
    <div class="container col-md-8 col-md-offset-2 pad">
        <div class="row">
            <!-- Not found message -->
            @if (Session::has('message'))
                <div id = "message-cont">
                    <div class="flash-message" id="message"> <i class="fa fa-exclamation-triangle"></i> {{ Session::get('message') }}</div>
                </div>
            @endif

            {{-- Errors for invalid data --}}
            @if ($errors->has())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        {{ $error }}<br>
                    @endforeach
                </div>
            @endif

            <h1 id="create-title">Enter your textbook information</h1>
            <!-- form begin -->
            <form action="/textbook/sell/store" method="post" id="textbook-create" class="form" enctype="multipart/form-data">
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
                    <input type="number" name="edition" value="{{ Input::old('edition') }}" class="form-control"/>
                </div>
                <!-- Num pg -->
                <div class="form-group">
                    <label><b>Number of Pages</b></label>
                    <input type="number" name="num_pages" value="{{ Input::old('num_pages') }}" class="form-control"/>
                </div>
                <!-- Select Binding -->
                <div class="form-group ws" id="binding">
                    <label><b>Binding</b></label>
                    @foreach($bindings as $key => $value)
                        <input type="radio" name="binding" value="{{ $value }}"/> {{ $value }}
                    @endforeach
                </div>

                <!-- Select Language -->
                <!-- TODO: a complete list of languages -->
                <div class="form-group">
                    <label><b>Language</b></label>
                    <select class="selectpicker" name="language" id="textbook-create lang">
                        @foreach($languages as $key => $value)
                            <option value="{{ $value }}" class="lang-select">{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
                <!-- upload image -->
                <div class="form-group ws">
                    <label><b>Cover Image</b></label>
                    <input type="file" name="image"/>
                </div>
                <input type="submit" name="submit" class="btn btn-primary" id="create-btn" value="Submit"/>
            </form>
        </div> <!-- End row -->
    </div> <!-- end container -->
</div> <!-- End fluid container (background) -->

    {{--<div id = "photo-license">Photo by</div>--}}

@endsection
