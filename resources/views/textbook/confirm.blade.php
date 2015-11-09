@extends('layouts.textbook')

@section('title', 'Confirm your book')

@section('searchbar')
    @include('includes.textbook.searchbar')
@endsection

@section('content')
    <div class="container">

        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="row">
                    <ol class="breadcrumb">
                        <li><a href="{{ url('/') }}">Home</a></li>
                        <li class="active">Confirm</li>
                    </ol>
                </div>

                <br>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Confirm the book
                        </h3>
                    </div>

                    <div class="panel-body">
                        @include('includes.textbook.book-details-confirm')
                    </div>

                    <div class="panel-footer">
                        <div class="row">
                            <div class="col-xs-6">
                                <a href="{{ url('textbook/buy/' . $book->id) }}" class="btn btn-primary btn-block">
                                    Buy
                                </a>
                            </div>
                            <div class="col-xs-6">
                                @if(Auth::guest())
                                    <a href="#" class="btn btn-default btn-block disabled">
                                        Login or signup to sell this book
                                    </a>
                                @else
                                    <a href="{{ url('textbook/sell/product/' . $book->id . '/create') }}" class="btn btn-default btn-block btn-to-details">Sell</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection