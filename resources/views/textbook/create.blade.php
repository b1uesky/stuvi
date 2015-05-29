@extends('textbook')

@section('content')
    {{--<ul class="nav nav-tabs">--}}
        {{--<li><a href="{{ url('/textbook/buy') }}">Buy</a></li>--}}
        {{--<li class="active"><a href="{{ url('/textbook/sell') }}">Sell</a></li>--}}
    {{--</ul>--}}

<div class = "container-fluid">
    <!-- add padding -->
    <div class="container col-md-8 col-md-offset-2">
        <div class="row">
            @if (Session::has('message'))
                <div class="flash-message">{{ Session::get('message') }}</div>
            @endif

            <h1> SOME STUFF HERE</h1>

            <form action="/textbook/sell/store" method="post" id="textbook-create" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group">
                    <label>ISBN</label>
                    <input type="number" name="isbn" class="form-control"/>
                </div>
                <div class="form-group">
                    <label>Title</label>
                    <input type="text" name="title" class="form-control"/>
                </div>
                <div class="form-group">
                    <label>Author</label>
                    <input type="text" name="author" class="form-control"/>
                </div>
                <div class="form-group">
                    <label>Edition</label>
                    <input type="number" name="edition" class="form-control"/>
                </div>
                <div class="form-group">
                    <label>Publisher</label>
                    <input type="text" name="publisher" class="form-control"/>
                </div>
                <div class="form-group">
                    <label>Publication Date</label>
                    <input type="date" name="publication_date" class="form-control"/>
                </div>
                <div class="form-group">
                    <label>Manufacturer</label>
                    <input type="text" name="manufacturer" class="form-control"/>
                </div>
                <div class="form-group">
                    <label>Number of Pages</label>
                    <input type="number" name="num_pages" class="form-control"/>
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
</div>
@endsection