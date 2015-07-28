@extends('app')

@section('title', 'FAQ')

@section('css')
    <link href="{{ asset('/css/faq.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container faq-container">
        @include('faq/side-nav')

        <div class="col-sm-7 col-sm-offset-1 qa-container">
            <div class="question-answer">
                <h2>FAQ - Orders</h2>

                <h3>What happens after I buy a book?</h3>

                <p>
                    After you make a purchase, we will collect the book from the seller and deliver it to you
                    after we verify its condition. This process may take a few days.
                </p>
            </div>
            <div class="question-answer">
                <h3>What happens when someone buys my book?</h3>

                <p>
                    We will notify you when your bold has been sold. You will then select a time for us to
                    pickup the book.
                </p>
            </div>
            <div class="question-answer">
                <h3>Is my credit card info secure?</h3>

                <p>
                    Yes! We use <a href="https://stripe.com/" target="_blank">Stripe</a> to secure all credit card
                    transactions.
                </p>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
@endsection