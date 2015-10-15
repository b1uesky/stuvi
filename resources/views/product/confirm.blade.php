@extends('layouts.textbook')

@section('title', 'Confirm your book')

@section('content')
    <div class="container">

        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="row">
                    <ol class="breadcrumb">
                        <li><a href="{{ url('textbook/sell') }}">Home</a></li>
                        <li class="active">Confirm</li>
                    </ol>
                </div>

                <div class="page-header">
                    <h1>Confirm Your Book</h1>
                </div>

                <div class="container-fluid">

                    @include('includes.textbook.book-details-confirm')

                    <br>

                    <div class="row">
                        <div class="col-xs-6">
                            <a href="{{ url('textbook/sell') }}" class="btn btn-muted btn-block">
                                No, this is not the book I want to sell.
                            </a>
                        </div>
                        <div class="col-xs-6">
                            @if(Auth::guest())
                                <a href="#" class="btn btn-primary btn-block disabled">Login or singup to continue</a>
                            @else
                                <a href="{{ url('textbook/sell/product/' . $book->id . '/create') }}" class="btn btn-primary btn-block btn-to-details">Continue</a>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection