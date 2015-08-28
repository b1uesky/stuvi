@extends('layouts.textbook')

@section('title', 'FAQ - General')

@section('content')
    <div class="container faq-container">
        @include('faq.side-nav')

        <div class="col-sm-7 col-sm-offset-1 qa-container">
            <h2>FAQ - General Questions</h2>
            <hr>
            <a name="school-email"></a>
            <div class="question-answer">
                <h3>Why do I need to log in with a school email address?</h3>
                <p>
                    We want to ensure that our marketplace is a safe environment for trading textbooks.
                    Therefore, we only allow verified college students to join our community.
                </p>
            </div>
            <a name="my-school"></a>
            <div class="question-answer">
                <h3>I can't find my college/university. Can I still use Stuvi?</h3>

                <p>
                    We're sorry that your school has not been included.
                    Please <a href="{{ url('/contact') }}">send us a message</a>
                    so we can expand our service to your school.
                </p>
            </div>
            <a name="bug"></a>
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
@endsection