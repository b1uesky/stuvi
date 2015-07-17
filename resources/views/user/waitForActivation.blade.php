@extends('app')

@section('title','Activation Required')

@section('css')
    <link rel="stylesheet" href="{{asset('/css/user_waitForActivation.css')}}">
@endsection

@section('content')

    <!-- message -->
    <div class="container" id="message-cont" xmlns="http://www.w3.org/1999/html">
        @if (Session::has('message'))
            <div class="flash-message" id="message">{{ Session::get('message') }}</div>
        @endif
    </div>

    <div class="container-fluid container-main">

        <div class="container container-content">

            <h1>Please Activate Your Account</h1>

            <p>In order to keep our village safe, we need to verify every user.</p>

            <p>Check your email at <code>{{ $user->email }}</code> and activate your account via the link sent with our
                welcome email. Thank you!</p>

            <p>Problems receiving the email? Check your spam inbox, or <a href="{{ url('user/activate/resend') }}">resend
                    your code</a>.</p>
        </div>
    </div>
@endsection

@section('javascript')
            <!-- required for active class in nav to work -->
    <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
@endsection