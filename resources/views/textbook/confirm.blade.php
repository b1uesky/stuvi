@extends('layouts.textbook')

@section('title', 'Confirm your book')

@section('content')
    <div class="container">

        <div class="row">
            <ol class="breadcrumb">
                <li><a href="{{ url('/') }}">Home</a></li>
                <li class="active">Confirm</li>
            </ol>
        </div>

        <div class="page-header">
            <h1>Confirm your book</h1>
        </div>

        <div class="row">
            <div class="col-xs-12">
                @include('includes.textbook.book-details')

                <hr>

                <div>
                    @if(count($book->availableProducts()) > 0)
                        <a href="{{ url('textbook/buy/' . $book->id) }}" class="btn btn-primary">Buy this book</a>
                    @endif

                    <a href="{{ url('textbook/sell/product/' . $book->id . '/create') }}" class="btn btn-warning">Sell this book</a>
                </div>

                <br>

                @if(Auth::guest())
                    <p class="text-info">
                        <span class="glyphicon glyphicon-log-in"></span>
                        To sell a book, you need to login first.
                    </p>
                @endif
            </div>

        </div>
    </div>
@endsection