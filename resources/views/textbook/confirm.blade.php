@extends('layouts.textbook')

@section('title', 'Confirm your book')

@section('content')
    <div class="container">

        <div class="row">
            <ol class="breadcrumb">
                <li><a href="{{ url('textbook/sell') }}">Home</a></li>
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
                    @else
                        <a href="#" class="btn btn-info disabled">Temporarily out of stock</a>
                    @endif

                    <a href="{{ url('textbook/sell/product/' . $book->id . '/create') }}" class="btn btn-default">Sell this book</a>
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

        {{--<div class="row">--}}
            {{--<div class="col-md-8 col-md-offset-2">--}}

                {{--<div class="panel panel-default">--}}
                    {{--<div class="panel-heading">--}}
                        {{--<h3 class="panel-title">--}}
                            {{--Confirm the book--}}
                        {{--</h3>--}}
                    {{--</div>--}}

                    {{--<div class="panel-body">--}}
                        {{--@include('includes.textbook.book-details-confirm')--}}
                    {{--</div>--}}

                    {{--<div class="panel-footer">--}}
                        {{--<div class="row">--}}
                            {{--<div class="col-xs-6">--}}
                                {{--@if(count($book->availableProducts()) > 0)--}}
                                    {{--<a href="{{ url('textbook/buy/' . $book->id) }}" class="btn btn-primary btn-block">--}}
                                        {{--Buy--}}
                                    {{--</a>--}}
                                {{--@else--}}
                                    {{--<a href="#" class="btn btn-warning btn-block disabled">Temporarily out of stock</a>--}}
                                {{--@endif--}}
                            {{--</div>--}}
                            {{--<div class="col-xs-6">--}}
                                {{--@if(Auth::guest())--}}
                                    {{--<a href="#" class="btn btn-default btn-block disabled">--}}
                                        {{--Login or sign up to sell this book--}}
                                    {{--</a>--}}
                                {{--@else--}}
                                    {{--<a href="{{ url('textbook/sell/product/' . $book->id . '/create') }}" class="btn btn-default btn-block">Sell</a>--}}
                                {{--@endif--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}

            {{--</div>--}}
        {{--</div>--}}
    </div>
@endsection