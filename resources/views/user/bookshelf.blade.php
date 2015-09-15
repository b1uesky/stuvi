{{-- The bookshelf page shows all the seller's books for sale, but not yet purchased --}}

@extends('layouts.textbook')

@section('title','Bookshelf')

@section('content')
    <div class="container">
        <div class="row">
            <ol class="breadcrumb">
                <li><a href="{{ url('textbook') }}">Home</a></li>
                <li class="active">Your bookshelf</li>
            </ol>
        </div>

        <div class="row page-content">
            {{-- Left nav--}}
            <div class="col-sm-3 margin-bottom-5">
                <ul class="nav nav-pills nav-stacked">
                    <li role="presentation"><a href="{{ url('user/profile') }}">Profile Settings</a></li>
                    <li role="presentation"><a href="{{ url('user/account') }}">Account Settings</a></li>
                    <li role="presentation"><a href="{{ url('user/email') }}">Email Settings</a></li>
                    <li role="presentation" class="active"><a href="{{ url('user/bookshelf') }}">Bookshelf</a></li>
                </ul>
            </div>

            {{-- Right content --}}
            <div class="col-sm-9">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Your books for sale</h3>
                    </div>
                    <div class="panel-body">
                        <div class="container-fluid">
                            <table class="table table-responsive table-default">
                                @foreach ($productsForSale as $product)
                                    <tr>
                                        <td class="col-sm-3">
                                            @if($product->book->imageSet->isManuallyCreated())
                                                @if($product->book->imageSet->small_image)
                                                    <a href="{{ url('textbook/buy/product/'.$product->id) }}">
                                                        <img class="img-responsive img-small" src="{{ config('aws.url.stuvi-book-img') . $product->book->imageSet->small_image }}">
                                                    </a>
                                                @else
                                                    <a href="{{ url('textbook/buy/product/'.$product->id) }}">
                                                        <img class="img-responsive img-small" src="{{ config('book.default_image_path.small') }}" alt="">
                                                    </a>
                                                @endif
                                            @else
                                                <a href="{{ url('textbook/buy/product/'.$product->id) }}">
                                                    <img class="img-responsive img-small" src="{{ $product->book->imageSet->medium_image or config('book.default_image_path.medium') }}">
                                                </a>
                                            @endif
                                        </td>
                                        <td class="col-sm-6">
                                            <div class="row">
                                                <a href="{{ url('textbook/buy/product/'.$product->id) }}">{{ $product->book->title }}</a>
                                            </div>

                                            <div class="row">
                                                @foreach($product->book->authors as $i => $author)
                                                    @if($i == 0)
                                                        <span class="for-sale-by">Author(s): </span>
                                                        <span class="for-sale-author">{{ $author->full_name }}</span>
                                                    @else
                                                        <span class="for-sale-author">, {{ $author->full_name }}</span>
                                                    @endif
                                                @endforeach
                                            </div>

                                            <div class="row">
                                                <span>ISBN-10: {{ $product->book->isbn10 }}</span>
                                            </div>

                                            <div class="row">
                                                <span>ISBN-13: {{ $product->book->isbn13 }}</span>
                                            </div>

                                            <div class="row">
                                                <span class="price">${{ $product->decimalPrice() }}</span>
                                            </div>
                                        </td>
                                        <td class="col-sm-3">
                                            <a href="{{ url('/textbook/sell/product/'.$product->id.'/edit') }}" class="btn btn-primary btn-block">Edit</a>

                                            <form action="{{ url('/textbook/sell/product/delete') }}" method="post" class="margin-top-5">
                                                {!! csrf_field() !!}
                                                <input type="hidden" name="id" value="{{ $product->id }}">
                                                <button type="submit" class="btn btn-danger btn-block">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection