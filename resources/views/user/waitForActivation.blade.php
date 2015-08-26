@extends('layouts.textbook')

@section('title','Activation Required')

@section('content')

    <div class="container-fluid container-main">

        <div class="container container-content">

            <h1>Please Activate Your Account</h1>

            <p>In order to keep our village safe, we need to verify every user.</p>

            <p>Check your email at <code>{{ $user->primaryEmail->email_address }}</code> and activate your account via the link sent with our
                welcome email. Thank you!</p>

            <p>Problems receiving the email? Check your spam inbox, or <a href="{{ url('user/activate/resend') }}">resend
                    your code</a>.</p>
        </div>
    </div>
@endsection