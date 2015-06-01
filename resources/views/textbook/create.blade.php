@extends('textbook')
    <head>
        <title>Stuvi - Create textbook</title>
        <link href="{{ asset('/css/create.css') }}" rel="stylesheet">
    </head>

@section('content')
    {{--<ul class="nav nav-tabs">--}}
        {{--<li><a href="{{ url('/textbook/buy') }}">Buy</a></li>--}}
        {{--<li class="active"><a href="{{ url('/textbook/sell') }}">Sell</a></li>--}}
    {{--</ul>--}}

<div class = "container-fluid">
    <!-- add padding -->
    <div class="container col-md-8 col-md-offset-2 pad">
        <div class="row">
            @if (Session::has('message'))
                <div class="flash-message" id="message">{{ Session::get('message') }}</div>
            @endif
            <!-- TODO: These fields are not specific enough. Please see http://easybib.com/mla-format/book-citation for an example -->
            <h1>Enter your textbook information</h1>

            <form action="/textbook/sell/store" method="post" id="textbook-create" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group">
                    <label><b>ISBN</b></label>
                    <input type="string" name="isbn" value="{{ $book->isbn or "" }}" class="form-control"/>
                </div>
                <div class="form-group">
                    <label><b>Title</b></label>
                    <input type="text" name="title" value="{{ $book->title or "" }}" class="form-control"/>
                </div>
                <div class="form-group">
                    <label><b>Author</b></label>
                    <input type="text" name="author" value="{{ $book->author or "" }}" class="form-control"/>
                </div>
                <div class="form-group">
                    <label><b>Edition</b></label>
                    <input type="number" name="edition" value="{{ $book->edition or 0 }}" class="form-control"/>
                </div>
                <div class="form-group">
                    <label><b>Publisher</b></label>
                    <input type="text" name="publisher" value="{{ $book->publisher or "" }}" class="form-control"/>
                </div>
                <div class="form-group">
                    <label><b>Publication Date</b></label>
                    <input type="date" name="publication_date" class="form-control"/>
                </div>
                <div class="form-group">
                    <label><b>Manufacturer</b></label>
                    <input type="text" name="manufacturer" value="{{ $book->manufacturer or "" }}" class="form-control"/>
                </div>
                <div class="form-group">
                    <label><b>Number of Pages</b></label>
                    <input type="number" name="num_pages" value="{{ $book->num_pages or 0 }}" class="form-control"/>
                </div>
                <div class="form-group">
                    <label><b>Binding</b></label>
                    <input type="radio" name="binding" value="0" checked/> Hard
                    <input type="radio" name="binding" value="1"/> Soft
                </div>

                <!-- TODO: a complete list of languages and their ids -->
                <div class="form-group">
                    <label><b>Language</b></label>
                    <select name="language" id="textbook-create">
                        <option value="0">English</option>
                        <option value="1">Spanish</option>
                        <option value="2">Chinese</option>
                    </select>
                </div>
                <input type="submit" name="submit" class="btn btn-primary" value="Submit"/>
            </form>
        </div>
    </div>
</div>
@endsection