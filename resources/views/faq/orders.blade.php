@extends('app')

@section('title', 'FAQ - Orders')

@section('css')
    <link href="{{ asset('/css/faq.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container faq-container">
        @include('faq.side-nav')

        <div class="col-sm-7 col-sm-offset-1 qa-container">
            <h2>FAQ - Orders</h2>
            <hr class="faq-line">
            <a name="after-buy"></a>
            <div class="question-answer">
                <h3>What happens after I buy a book?</h3>
                <p>
                    After you make a purchase, we will collect the book from the seller and deliver it to you
                    after we verify its condition. This process may take a few days.
                </p>
            </div>
            <a name="bought"></a>
            <div class="question-answer">
                <h3>What happens when someone buys my book?</h3>
                <p>
                    We will notify you when your bold has been sold. You will then select a time for us to
                    pickup the book.
                </p>
            </div>
            <a name="secure"></a>
            <div class="question-answer">
                <h3>Is my credit card info secure?</h3>
                <p>
                    Yes! We use <a href="https://stripe.com/" target="_blank">Stripe</a> to
                    secure all credit/debit card transactions.
                </p>
            </div>
            <a name="cancel-order"></a>
            <div class="question-answer">
                <h3>How do I cancel an order?</h3>
                <p>
                    Please go to <a href="">your orders</a> page. There you can see a list
                    of your previous orders and choose to cancel an order.
                </p>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
@endsection