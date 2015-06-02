@extends('app')

@section('content')
    <head>
        <link href="{{ asset('/css/contact.css') }}" rel="stylesheet">
        <title>Contact Us</title>
    </head>

    <div class="container-fluid">
        <div class="title-container">
            <h2 id="contact-title">Contact Us</h2>
            <p>Please feel free to ask a question or give us feedback</p>
        </div>

        <div class="col-sm-6 contact-form-container">
            <form class="form-horizontal login-form" role="form" method="POST" action="{{ url('/auth/login') }}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group">
                    <label>First Name (*only required if not logged in)</label>
                    <input type="text" class="form-control">
                </div>
                <div class="form-group">
                    <label>Last Name (*only required if not logged in)</label>
                    <input type="text" class="form-control">
                </div>
                <div class="form-group">
                    <label>Email (*only required if not logged in)</label>
                    <input type="text" class="form-control">
                </div>
                <div class="form-group">
                    <label>Message</label>
                    <textarea class="form-control" rows="5"></textarea>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn contact-button">Submit</button>
                </div>
            </form>
        </div>

        <div class="col-sm-5 social-container">
            <h4>Connect with us on social media!</h4>
            <div class="social-links">
                <a href="#">
                    <img src="{{ asset('/img/facebook.png') }}">
                </a>
                <a href="#">
                    <img src="{{ asset('/img/twitter.png') }}">
                </a>
                <a href="#">
                    <img src="{{ asset('/img/github.png') }}">
                </a>
            </div>
        </div>
    </div>


@endsection