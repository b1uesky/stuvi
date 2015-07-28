@extends('app')

@section('title', 'FAQ')

@section('css')
    <link href="{{ asset('/css/faq.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container faq-container">
        @include('faq/side-nav')

        <div class="col-sm-7 col-sm-offset-1 qa-container">
            <h2>FAQ - General Questions</h2>
            <div class="question-answer">
                <h3>Why do I need to log in with a school email address?</h3>
                <p>
                    We want to ensure that our marketplace is a safe environment for trading textbooks.
                    Therefore, we only allow verified college students to join our community.
                </p>
            </div>
            <div class="question-answer">
                <h3>I can't find my college/university. Can I still use Stuvi?</h3>

                <p>
                    We're sorry that your school has not been included.
                    Please <a href="{{ url('/contact') }}">send us a message</a>
                    so we can expand our service to your school.
                </p>
            </div>
            <div class="question-answer">
                <h3>I found a bug. Where can I report that?</h3>
                <p>
                    We apologize for the inconvenience. Please go to our <a href="{{ url('/contact') }}">contact
                        page</a> to report the bug.
                </p>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
@endsection