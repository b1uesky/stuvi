
@extends('app')

@section('content')
    <head>
        <title> Stuvi - Activation Required </title>
        <link rel="stylesheet" href="{{asset('/css/user/waitForActivation.css')}}"

    </head>

    <div class="container-fluid container-main">

        <div class="container container-content">

        <h1>Please Activate Your Account</h1>
        <p>In order to keep our village safe, we need to verify every user.</p>
        <p>Check your email at <code>{{ $user->email }}</code> and activate your account via the link sent with our welcome email. Thank you!</p>
        <p>Problems receiving the email? Check your Spam inbox, or <a href="">resend your code</a>.</p>
            <!-- TODO: Link for resending code -->

        </div>


    </div>





@endsection

@section('javascript')
    <!-- required for active class in nav to work -->
    <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
@endsection