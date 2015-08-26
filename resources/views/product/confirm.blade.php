@extends('layouts.textbook')

@section('title', 'Confirm your book')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="page-header">
                    <h1>Confirm Your Book</h1>
                </div>

                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xs-4">
                            @if($book->imageSet->medium_image)
                                <img class="img-responsive"
                                     src="{{ config('aws.url.stuvi-book-img') . $book->imageSet->medium_image }}">
                            @else
                                <img class="img-responsive"
                                     src="{{ config('book.default_image_path.medium') }}"/>
                            @endif
                        </div>

                        <div class="col-xs-8">
                            <h3 class="no-margin-top">
                                <a href="{{ url('textbook/buy/' . $book->id) }}">{{ $book->title }}</a>
                            </h3>

                            <table class="table table-book-details">
                                <tr>
                                    <th>
                                        @if(count($book->authors) > 1)
                                            Authors:
                                        @else
                                            Author:
                                        @endif
                                    </th>
                                    <td>
                                        @foreach($book->authors as $index => $author)
                                            @if($index == 0)
                                                {{ $author->full_name }}
                                            @else
                                                , {{ $author->full_name }}
                                            @endif
                                        @endforeach
                                    </td>
                                </tr>

                                <tr>
                                    <th>
                                        ISBN-10:
                                    </th>
                                    <td>
                                        {{ $book->isbn10 }}
                                    </td>
                                </tr>

                                <tr>
                                    <th>
                                        ISBN-13:
                                    </th>
                                    <td>
                                        {{ $book->isbn13 }}
                                    </td>
                                </tr>

                                <tr>
                                    <th>
                                        Number of Pages:
                                    </th>
                                    <td>
                                        {{ $book->num_pages }}
                                    </td>
                                </tr>
                            </table>

                        </div>
                    </div>

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