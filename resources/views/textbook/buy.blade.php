{{--Textbook buy page--}}

@extends('layouts.textbook')

@section('title', 'Buy Textbooks')
@section('description', 'Buy textbooks from other students without leaving home.')

@section('content')

        <!-- Search Bar Container-->
        <div class="container-fluid container-image">
            <div class="va-container va-container-h va-container-v">
                <div class="va-middle text-center">
                    <h1 class="title">Buy Textbooks</h1>

                    @include('includes.textbook.buy-searchbar')
                </div>
            </div>

        </div>

        <!-- Textbook page bottom half -->
        <section class="textbook-buy-sell-switch">
            <div class="container">
                <div class="row">
                    <ul>
                        <li class="active"><a href="{{ url('textbook/buy') }}">Buy</a></li>
                        <li><a href="{{ url('textbook/sell') }}">Sell</a></li>
                    </ul>
                </div>
            </div>
        </section>

        <section class="textbook-intro">

            <div class="container">
                <div class="row">
                    <div class="col-sm-6">
                        {{--<div>Icon made by <a href="http://handdrawngoods.com" title="Hand Drawn Goods">Hand Drawn Goods</a> from <a href="http://www.flaticon.com" title="Flaticon">www.flaticon.com</a> is licensed under <a href="http://creativecommons.org/licenses/by/3.0/" title="Creative Commons BY 3.0">CC BY 3.0</a></div>--}}
                        <img class="img-responsive img-intro center-block" src="https://s3.amazonaws.com/stuvi-icon/books104.png" alt="placeholder">
                    </div>
                    <div class="col-sm-6">
                        <h3>Find your books</h3>
                        <p>
                            Search the Stuvi database to find books from students near you. Search by book name, author or ISBN to continue!
                        </p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6 col-sm-push-6">
                        {{--<div>Icon made by <a href="http://handdrawngoods.com" title="Hand Drawn Goods">Hand Drawn Goods</a> from <a href="http://www.flaticon.com" title="Flaticon">www.flaticon.com</a> is licensed under <a href="http://creativecommons.org/licenses/by/3.0/" title="Creative Commons BY 3.0">CC BY 3.0</a></div>--}}
                        <img class="img-responsive img-intro center-block" src="https://s3.amazonaws.com/stuvi-icon/transport625.png" alt="placeholder">
                    </div>

                    <div class="col-sm-6 col-sm-pull-6">
                        <h3>Book delivery</h3>

                        <p>
                            We will deliver the book directly to you after you make a purchase. Our own team of couriers
                            will make sure your book is delivered quickly, and check that your book is in its advertised
                            condition.
                        </p>
                    </div>

                </div>
                <div class="row">
                    <div class="col-sm-6">
                        {{--<div>Icon made by <a href="http://handdrawngoods.com" title="Hand Drawn Goods">Hand Drawn Goods</a> from <a href="http://www.flaticon.com" title="Flaticon">www.flaticon.com</a> is licensed under <a href="http://creativecommons.org/licenses/by/3.0/" title="Creative Commons BY 3.0">CC BY 3.0</a></div>--}}
                        <img class="img-responsive img-intro center-block" src="https://s3.amazonaws.com/stuvi-icon/currency36.png" alt="">
                    </div>
                    <div class="col-sm-6">
                        <h3>Save money and study</h3>

                        <p>
                            Find the best prices for textbooks without leaving the comfort of your dorm.
                        </p>
                    </div>
                </div>
            </div>
        </section>

@endsection