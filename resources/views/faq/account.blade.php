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
                <h2>FAQ - Account</h2>

                <h3>How do I edit my account information?</h3>

                <p>
                    Please go to the <a href="">account page</a> to edit your account information.
                </p>
            </div>
            <div class="question-answer">
                <h3>Can I change the privacy of my profile?</h3>

                <p>
                    We will notify you when your bold has been sold. You will then select a time for us to
                    pickup the book.
                </p>
            </div>
            <div class="question-answer">
                <h3>How do I change my email settings?</h3>

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