@extends('layouts.textbook')

@section('title', 'Trade-In Program')

@section('content')

    <div id="trade-in-sections">
        <section id="trade-in-header">
            <div class="jumbotron">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12 text-center">
                            <h1>Textbook Trade-In Program</h1>
                            <br>
                            <a href="{{ url('/') }}" class="btn btn-lg btn-warning">Sell Your Textbook Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="trade-in-step-1">
            <div class="jumbotron">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-6 col-sm-push-6">
                            <img class="center-block" src="https://s3.amazonaws.com/stuvi-graphics/checking-task-list-by-hand.png">
                        </div>

                        <div class="col-sm-6 col-sm-pull-6">
                            <h2>1. Post Your Book</h2>
                            <p>Simply upload your textbook and check<br>
                                <strong class="text-checkbox"><span class="glyphicon glyphicon-check"></span> I would like to join the Stuvi Book Trade-in Program</strong>.</p>
                            <small class="text-muted">* You can join the program on your textbook page as well.</small>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="trade-in-step-2">
            <div class="jumbotron">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-6">
                            <img class="center-block" src="https://s3.amazonaws.com/stuvi-graphics/people-in-meeting.png">
                        </div>

                        <div class="col-sm-6">
                            <h2>2. Wating For Approval</h2>
                            <p>Our team will review your book, offer a trade-in price and send you an email with details once we approved your book.</p>
                            <small class="text-muted">* This process may take at most 2 days.</small>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="trade-in-step-3">
            <div class="jumbotron">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-6 col-sm-push-6">
                            <img class="center-block" src="https://s3.amazonaws.com/stuvi-graphics/money-bg-exchange.png">
                        </div>

                        <div class="col-sm-6 col-sm-pull-6">
                            <h2>3. Schedule and Get Paid</h2>
                            <p>After you accept the offer and schedule a pickup, our courier will come to pickup your book.</p>
                            <small class="text-muted">* Get paid by cash or PayPal.</small>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <section id="trade-in-final">
        <div class="jumbotron">
            <div class="container">
                <div class="row">
                    <div class="text-center margin-30">
                        <a href="{{ url('/') }}" class="btn btn-lg btn-warning">Sell Your Textbook Now</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection