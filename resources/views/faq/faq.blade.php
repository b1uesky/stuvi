@extends('app')

@section('title', 'FAQ')

@section('css')
    <link href="{{ asset('/css/faq.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container faq-container">
        <div class="col-sm-3 faq-links-container">
            <h4>General Questions</h4>
            <ul class="faq-list">
                <li>
                    <a>Why do I need to log in with a school email address?</a>
                </li>
            </ul>
            <h4>Textbook</h4>
            <ul class="faq-list">
                <li>
                    <a></a>
                </li>
            </ul>
            <h4>Orders</h4>
            <ul class="faq-list">
                <li>
                    <a>What happens after I buy a book?</a>
                </li>
                <li>
                    <a>What happens when someone buys my book?</a>
                </li>
            </ul>
            <h4>Account</h4>
            <ul class="faq-list">
                <li>
                    <a>How do I edit my account information?</a>
                </li>
                <li>
                    <a>Change I change the privacy of my profile?</a>
                </li>
            </ul>
        </div>
        <div class="col-sm-7 col-sm-offset-1 general-container">
            <h3>Why do I need to log in with a school email address?</h3>

            <p>

            </p>
        </div>
    </div>
@endsection

@section('javascript')
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
@endsection