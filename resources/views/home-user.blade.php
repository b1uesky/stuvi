@extends('layouts.textbook')

@section('title', 'Home')

@section('content')

    <div class="container-fluid sections-container">

        {{-- Popular --}}
        <div class="row">
            <div class="section-header">
                <span class="section-title">Popular</span>

                {{--<span class="section-see-more">--}}
                    {{--<a href="#" class="btn btn-default btn-sm">--}}
                        {{--See More <span class="glyphicon glyphicon-menu-right"></span>--}}
                    {{--</a>--}}
                {{--</span>--}}
            </div>

            <div class="section-items">
                @foreach($popular_products as $product)
                    <div class="item">
                        <div class="item-thumbnail">
                            <a href="{{ url('textbook/buy/product/'.$product->id) }}" target="_blank">
                                <img src="{{ $product->images[0]->getImagePath('medium') }}" class="img-rounded" alt="">
                            </a>
                        </div>

                        <div class="item-info">
                            <div class="item-price">${{ $product->price }}</div>
                            <div class="item-title">{{ $product->book->title }}</div>
                            <div class="item-condition">{{ config('product.conditions.general_condition')[$product->condition->general_condition] }}</div>
                        </div>

                    </div>
                @endforeach
            </div>
        </div>

        {{-- New --}}
        <div class="row">
            <div class="section-header">
                <span class="section-title">New</span>

                {{--<span class="section-see-more">--}}
                    {{--<a href="#" class="btn btn-default btn-sm">--}}
                        {{--See More <span class="glyphicon glyphicon-menu-right"></span>--}}
                    {{--</a>--}}
                {{--</span>--}}
            </div>

            <div class="section-items">
                @foreach($new_products as $product)
                    <div class="item">
                        <div class="item-thumbnail">
                            <a href="{{ url('textbook/buy/product/'.$product->id) }}" target="_blank">
                                <img src="{{ $product->images[0]->getImagePath('medium') }}" class="img-rounded" alt="">
                            </a>
                        </div>

                        <div class="item-info">
                            <div class="item-price">${{ $product->decimalPrice() }}</div>
                            <div class="item-title">{{ $product->book->title }}</div>
                            <div class="item-condition">{{ config('product.conditions.general_condition')[$product->condition->general_condition] }}</div>
                        </div>

                    </div>
                @endforeach
            </div>
        </div>
    </div>

@endsection
