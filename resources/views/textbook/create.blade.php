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
                    <input type="string" name="isbn" value="{{ $book->isbn or "" }}" class="form-control"/>
                </div>
                <!-- Title -->
                <div class="form-group">
                    <label><b>Title</b></label>
                    <input type="text" name="title" value="{{ $book->title or "" }}" class="form-control"/>
                </div>
                <!-- Author -->
                <div class="form-group">
                    <label><b>Author</b></label>
                    <input type="text" name="author" value="{{ $book->author or "" }}" class="form-control"/>
                </div>
                <!-- Edition -->
                <div class="form-group">
                    <label><b>Edition</b></label>
                    <input type="number" name="edition" value="{{ $book->edition or 0 }}" class="form-control"/>
                </div>
                <!-- Publisher -->
                <div class="form-group">
                    <label><b>Publisher</b></label>
                    <input type="text" name="publisher" value="{{ $book->publisher or "" }}" class="form-control"/>
                </div>
                <!-- Pub date -->
                <div class="form-group">
                    <label><b>Publication Date</b></label>
                    <input type="date" name="publication_date" class="form-control"/>
                </div>
                <!-- Manufac. -->
                <div class="form-group">
                    <label><b>Manufacturer</b></label>
                    <input type="text" name="manufacturer" value="{{ $book->manufacturer or "" }}" class="form-control"/>
                </div>
                <!-- Num pg -->
                <div class="form-group">
                    <label><b>Number of Pages</b></label>
                    <input type="number" name="num_pages" value="{{ $book->num_pages or 0 }}" class="form-control"/>
                </div>
                <!-- binding -->
                <div class="form-group ws" id="binding">
                    <label><b>Binding</b></label>
                    <input type="radio" name="binding" value="1" checked/> Hard
                    <input type="radio" name="binding" value="2"/> Soft
                </div>

                <!-- select language -->
                <!-- TODO: a complete list of languages and their ids -->
                <div class="form-group">
                    <label><b>Language</b></label>
                    <select class="selectpicker" name="language" id="textbook-create lang">
                        <option value="1" class="lang-select">English</option>
                        <option value="2" class="lang-select">Spanish</option>
                        <option value="3" class="lang-select">Chinese</option>
                    </select>
                </div>
                <!-- upload image -->
                <div class="form-group ws">
                    <label >Cover Image</label>
                    <input type="file" name="image"/>
                </div>
                <input type="submit" name="submit" class="btn btn-primary" id="create-btn" value="Submit"/>
            </form>
        </div> <!-- End row -->
    </div> <!-- end container -->
</div> <!-- End fluid container (background) -->

    {{--<div id = "photo-license">Photo by</div>--}}

@endsection
