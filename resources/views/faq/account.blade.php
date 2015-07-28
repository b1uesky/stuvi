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
                    Please go to the <a href="{{ url('/user/account') }}">account page</a> to edit your account
                    information.
                </p>
            </div>
            <div class="question-answer">
                <h3>Can I change the privacy of my profile?</h3>
                <p>
                    Yes. Please go to the <a href="">privacy settings page</a> to edit the visibility of your profile.
                </p>
            </div>
            <div class="question-answer">
                <h3>How do I change my email settings?</h3>
                <p>
                    You can change all email preferences on the <a href="">email settings page.</a>
                </p>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
@endsection