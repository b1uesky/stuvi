{{-- The bookshelf page shows all the seller's books for sale, but not yet purchased --}}

@extends('layouts.textbook')

@section('title','Bookshelf')

@section('content')
    <div class="container">
        <div class="row">
            <ol class="breadcrumb">
                <li><a href="{{ url('/') }}">Home</a></li>
                <li class="active">Your bookshelf</li>
            </ol>
        </div>

        <div class="row page-content">
            {{-- Left nav--}}
            <div class="col-sm-3">
                @include('includes.textbook.settings-panel')
            </div>

            {{-- Right content --}}
            <div class="col-sm-9">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Your books for sale</h3>
                    </div>
                    <div class="panel-body">
                        @foreach($productsForSale as $product)
                            <div class="row">
                                <div class="col-sm-9 margin-bottom-15">
                                    @include('includes.textbook.product-details')
                                </div>

                                <div class="col-sm-3">
                                    <a href="{{ url('/textbook/sell/product/'.$product->id.'/edit') }}" class="btn btn-sm btn-primary btn-block">
                                        <span class="glyphicon glyphicon-edit"></span> Edit
                                    </a>
                                    <button type="button" class="btn btn-sm btn-default btn-block" data-toggle="modal"
                                            data-target="#delete-product"
                                            data-product-id="{{ $product->id }}"
                                            data-book-title="{{ $product->book->title }}">
                                        <span class="glyphicon glyphicon-remove"></span> Delete
                                    </button>
                                </div>
                            </div>

                            <hr>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

    </div>

    @include('includes.modal.delete-product')

@endsection