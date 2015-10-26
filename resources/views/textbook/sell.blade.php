{{--Textbook sell page--}}

@extends('layouts.textbook')

@section('title', 'Sell Your Textbooks')
@section('description', 'Sell your textbooks to other students without leaving home.')

@section('content')

        <!-- Search Bar Container-->
        <div class="container-fluid container-image">

            <div class="va-container va-container-h va-container-v">
                <div class="va-middle text-center">
                    <h1 class="title">Sell Your Textbooks</h1>

                    @include('includes.textbook.sell-searchbar')
                </div>
            </div>

        </div>

        <section class="textbook-buy-sell-switch">
            <div class="container">
                <div class="row">
                    <ul>
                        <li><a href="{{ url('textbook/buy') }}">Buy</a></li>
                        <li class="active"><a href="{{ url('textbook/sell') }}">Sell</a></li>
                    </ul>
                </div>
            </div>
        </section>

        <section class="textbook-intro">
            <div class="container">

                <div class="row">
                    <div class="col-sm-6">
                        {{--<div>Icon made by <a href="http://handdrawngoods.com" title="Hand Drawn Goods">Hand Drawn Goods</a> from <a href="http://www.flaticon.com" title="Flaticon">www.flaticon.com</a> is licensed under <a href="http://creativecommons.org/licenses/by/3.0/" title="Creative Commons BY 3.0">CC BY 3.0</a></div>--}}
                        <img class="img-responsive img-intro center-block" src="https://s3.amazonaws.com/stuvi-icon/worldwide3.png" alt="placeholder">
                    </div>
                    <div class="col-sm-6">
                        <h3>Sell to your classmates</h3>

                        <p>Sell to students near you with the same classes. We make the the entire process smooth and
                            easy, so you can spend less time selling and more time doing the things you enjoy.</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6 col-sm-push-6">
                        {{--<div>Icon made by <a href="http://handdrawngoods.com" title="Hand Drawn Goods">Hand Drawn Goods</a> from <a href="http://www.flaticon.com" title="Flaticon">www.flaticon.com</a> is licensed under <a href="http://creativecommons.org/licenses/by/3.0/" title="Creative Commons BY 3.0">CC BY 3.0</a></div>--}}
                        <img class="img-responsive img-intro center-block" src="https://s3.amazonaws.com/stuvi-icon/dailycalendar20.png" alt="placeholder">
                    </div>

                    <div class="col-sm-6 col-sm-pull-6">
                        <h3>Select your pickup time</h3>

                        <p>
                            You will be notified once your book has been sold. Then you can select a time
                            for us to come pickup your book. You will then be paid via Paypal once the book is delivered.
                        </p>
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-6">
                        {{--<div>Icon made by <a href="http://handdrawngoods.com" title="Hand Drawn Goods">Hand Drawn Goods</a> from <a href="http://www.flaticon.com" title="Flaticon">www.flaticon.com</a> is licensed under <a href="http://creativecommons.org/licenses/by/3.0/" title="Creative Commons BY 3.0">CC BY 3.0</a></div>--}}
                        <img class="img-responsive img-intro center-block" src="https://s3.amazonaws.com/stuvi-icon/currency36.png" alt="">
                    </div>
                    <div class="col-sm-6">
                        <h3>Save Money!</h3>

                        <p>There's no need to pay for packaging supplies and shipping. We take care of the entire
                            process!
                        </p>
                    </div>
                </div>
            </div>
        </section>

@endsection
