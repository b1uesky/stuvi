@extends('textbook')

@section('content')
    {{--<ul class="nav nav-tabs">--}}
        {{--<li><a href="{{ url('/textbook/buy') }}">Buy</a></li>--}}
        {{--<li class="active"><a href="{{ url('/textbook/sell') }}">Sell</a></li>--}}
    {{--</ul>--}}

    <div class="container">
        <div class="row">
            <form action="/textbook/sell/search" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group">
                    <label>Find the Textbook You'd Like to Trade In</label>
                    <input type="text" name="isbn" class="form-control" placeholder="Enter the textbook ISBN"/>
                </div>
                <input type="submit" name="search" class="btn btn-primary" value="Search"/>
            </form>
        </div>
    </div>
@endsection