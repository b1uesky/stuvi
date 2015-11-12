@extends('layouts.textbook')

@section('title', 'Home')

@section('content')

    <div class="container">

        {{-- New --}}
        <div class="row">
            <div class="section-header">
                <span class="section-title">New Textbooks</span>

                <span class="section-see-more">
                    <a href="{{ url('textbook/buy') }}" class="text-right">See more</a>
                </span>

                <hr>
            </div>


            @foreach($new_products as $product)
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

@endsection
