{{-- Page for creating a new textbook --}}


@extends('layouts.textbook')

@section('title', 'Donate a textbook')

@section('content')

    <div class="container">

        <div class="page-header">
            <h1>Donate your book</h1>
        </div>

        <form action="{{ url('textbook/donate/store') }}" method="post">
            {!! csrf_field() !!}

            <div class="form-group">
                <label>How many books would you like to donate?</label>
                <input type="number" name="quantity" class="form-control" min="1">
            </div>



            <input type="submit" class="btn btn-lg btn-primary">
        </form>

    </div>

@endsection


