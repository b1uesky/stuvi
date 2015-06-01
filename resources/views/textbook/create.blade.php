@extends('textbook')

@section('content')
    {{--<ul class="nav nav-tabs">--}}
        {{--<li><a href="{{ url('/textbook/buy') }}">Buy</a></li>--}}
        {{--<li class="active"><a href="{{ url('/textbook/sell') }}">Sell</a></li>--}}
    {{--</ul>--}}

    <div class="container">
        <div class="row">
            @if (Session::has('message'))
                <div class="flash-message">{{ Session::get('message') }}</div>
            @endif

            <form action="/textbook/sell/store" method="post" id="textbook-create" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group">
                    <label>ISBN</label>
                    <input type="string" name="isbn" value="{{ $book->isbn or "" }}" class="form-control"/>
                </div>
                <div class="form-group">
                    <label>Title</label>
                    <input type="text" name="title" value="{{ $book->title or "" }}" class="form-control"/>
                </div>
                <div class="form-group">
                    <label>Author</label>
                    <input type="text" name="author" value="{{ $book->author or "" }}" class="form-control"/>
                </div>
                <div class="form-group">
                    <label>Edition</label>
                    <input type="number" name="edition" value="{{ $book->edition or 0 }}" class="form-control"/>
                </div>
                <div class="form-group">
                    <label>Publisher</label>
                    <input type="text" name="publisher" value="{{ $book->publisher or "" }}" class="form-control"/>
                </div>
                <div class="form-group">
                    <label>Publication Date</label>
                    <input type="date" name="publication_date" class="form-control"/>
                </div>
                <div class="form-group">
                    <label>Manufacturer</label>
                    <input type="text" name="manufacturer" value="{{ $book->manufacturer or "" }}" class="form-control"/>
                </div>
                <div class="form-group">
                    <label>Number of Pages</label>
                    <input type="number" name="num_pages" value="{{ $book->num_pages or 0 }}" class="form-control"/>
                </div>
                <div class="form-group">
                    <label>Binding</label>
                    <input type="radio" name="binding" value="0" checked/> Hard
                    <input type="radio" name="binding" value="1"/> Soft
                </div>

                {{--TODO: a complete list of languages and their ids--}}
                <div class="form-group">
                    <label>Language</label>
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
@endsection