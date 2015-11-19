@extends('layouts.textbook')

@section('title', 'Trade-In Program')

@section('content')

    <div class="trade-in-sections">
        <section id="trade-in-header">
            <div class="jumbotron">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12 text-center">
                            <h1>Textbook Trade-In Program</h1>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="trade-in-step-1">
            <div class="jumbotron">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-6">

                        </div>

                        <div class="col-sm-6">
                            <h2>Post your book</h2>
                            <p>Upload your textbook and make sure to check "I would like to join the Stuvi Book Trade-in Program".</p>
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
                            <h2>Wating for approval</h2>
                            <p>Our team will review your book, offer a trade-in price and send you an email with details once we approved your book.</p>
                            <small>* This process may take at most 2 days.</small>
                        </div>

                        <div class="col-sm-6">

                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="trade-in-step-3">
            <div class="jumbotron">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-6">

                        </div>

                        <div class="col-sm-6">
                            <h2>Schedule and Get Paid</h2>
                            <p>If you decide to take the deal, our courier will come to pickup your book and pay you at the time you scheduled.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    {{--<div class="container">--}}

        {{--<div class="row">--}}
            {{----}}
            {{----}}
            {{----}}
            {{--<div class="col-md-6 col-md-offset-3">--}}
                {{--<div class="page-header">--}}
                    {{--<h1>Textbook Trade-In Program</h1>--}}
                {{--</div>--}}

                {{--<p class="lead">--}}
                    {{--By joining the Stuvi Book Trade-in program, you will have an option to sell the book directly to Stuvi.--}}
                    {{--Our team will review your book, offer a trade-in price and send you an email with details once we approved your book.--}}
                    {{--Of course, you decide to take the deal or not.--}}
                    {{--This process may take at most 2 days. You can change this option later.--}}
                {{--</p>--}}
            {{--</div>--}}
        {{--</div>--}}

    {{--</div>--}}

@endsection