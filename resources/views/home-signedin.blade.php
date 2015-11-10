@extends('layouts.textbook')

@section('title', 'Home')

@section('content')

    <div class="container">
        <div class="row">
            <div class="section-header">
                <span class="section-title">New Textbooks</span>

                <span class="section-view-more">
                    <a href="{{ url('textbook/buy') }}" class="text-right">View more</a>
                </span>
            </div>


            <div class="panel panel-default">
                <div class="panel-body">
                    @foreach($products as $product)
                        <div class="col-md-3 col-sm-4 col-xs-6">
                            <div class="item">
                                <div class="item-thumbnail">
                                    <a href="{{ url('textbook/buy/product/'.$product->id) }}" target="_blank">
                                        <img src="{{ $product->book->imageSet->getImagePath('small') }}" alt="">
                                    </a>
                                </div>

                                <div class="item-price">
                                    <div>${{ $product->decimalPrice() }}</div>
                                </div>
                            </div>

                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>

@endsection
