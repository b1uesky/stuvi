@extends('textbook')

@section('content')
    <ul class="nav nav-tabs">
        <li><a href="{{ url('/textbook/buy') }}">Buy</a></li>
        <li class="active"><a href="{{ url('/textbook/sell') }}">Sell</a></li>
    </ul>

    <div class="container">
        <div class="row">
            @if (Session::has('message'))
                <div class="flash-message">{{ Session::get('message') }}</div>
            @endif

            <form action="/textbook/sell/store" method="post" id="textbook-create">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group">
                    <label>ISBN</label>
                    <input type="number" name="isbn" class="form-control" placeholder="Enter the 10 or 13 digits ISBN"/>
                </div>
                <div class="form-group">
                    <label>Title</label>
                    <input type="text" name="title" class="form-control" placeholder="Enter the textbook title"/>
                </div>
                <div class="form-group">
                    <label>Author</label>
                    <input type="text" name="author" class="form-control" placeholder="Enter the textbook author"/>
                </div>
                <div class="form-group">
                    <label>Edition</label>
                    <input type="text" name="edition" class="form-control" placeholder="Enter the textbook edition"/>
                </div>
                <div class="form-group">
                    <label>Publisher</label>
                    <input type="text" name="publisher" class="form-control" placeholder="Enter the textbook publisher"/>
                </div>
                <div class="form-group">
                    <label>Publication Date</label>
                    <input type="date" name="publication_date" class="form-control"/>
                </div>
                <div class="form-group">
                    <label>Manufacturer</label>
                    <input type="text" name="manufacturer" class="form-control" placeholder="Enter the textbook manufacturer"/>
                </div>
                <div class="form-group">
                    <label>Number of Pages</label>
                    <input type="number" name="num_pages" class="form-control" placeholder="Enter the total number of pages"/>
                </div>
                <div class="form-group">
                    <label>Binding</label>
                    <input type="radio" name="binding" value="hard"/> Hard
                    <input type="radio" name="binding" value="soft"/> Soft
                </div>
                <div class="form-group">
                    <label>Language</label>
                    <select name="language" id="textbook-create">
                        <option value="english">English</option>
                        <option value="spanish">Spanish</option>
                        <option value="chinese">Chinese</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Image</label>
                    <input type="file" name="image"/>
                </div>
                <input type="submit" name="search" class="btn btn-primary" value="Submit"/>
            </form>
        </div>
    </div>
@endsection