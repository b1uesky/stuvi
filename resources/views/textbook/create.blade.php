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
            <h1 id="create-title">Enter your textbook information</h1>
            <!-- form begin -->
            <form action="/textbook/sell/store" method="post" id="textbook-create" class="form" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <!-- ISBN -->
                <div class="form-group">
                    <label><b>ISBN</b></label>
                    <input type="string" name="isbn" class="form-control" required/>
                </div>
                <!-- Title -->
                <div class="form-group">
                    <label><b>Title</b></label>
                    <input type="text" name="title" class="form-control" required/>
                </div>
                <!-- Authors -->
                <div class="form-group">
                    <label><b>Author(s)</b></label>
                    <small>Seperate authors by ,</small>
                    <input type="text" name="authors" class="form-control" required/>
                </div>
                <!-- Edition -->
                <div class="form-group">
                    <label><b>Edition</b></label>
                    <input type="number" name="edition" class="form-control" required/>
                </div>
                <!-- Num pg -->
                <div class="form-group">
                    <label><b>Number of Pages</b></label>
                    <input type="number" name="num_pages" class="form-control" required/>
                </div>
                <!-- Select Binding -->
                <div class="form-group ws" id="binding">
                    <label><b>Binding</b></label>
                    @foreach($bindings as $key => $value)
                        <input type="radio" name="binding" value="{{ $value }}" required/> {{ $value }}
                    @endforeach
                </div>

                <!-- Select Language -->
                <!-- TODO: a complete list of languages -->
                <div class="form-group">
                    <label><b>Language</b></label>
                    <select class="selectpicker" name="language" id="textbook-create lang">
                        @foreach($languages as $key => $value)
                            <option value="{{ $value }}" class="lang-select" required>{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
                <!-- upload image -->
                <div class="form-group ws">
                    <label><b>Cover Image</b></label>
                    <input type="file" name="image" required/>
                </div>
                <input type="submit" name="submit" class="btn btn-primary" id="create-btn" value="Submit"/>
            </form>
        </div> <!-- End row -->
    </div> <!-- end container -->
</div> <!-- End fluid container (background) -->

    {{--<div id = "photo-license">Photo by</div>--}}

@endsection
