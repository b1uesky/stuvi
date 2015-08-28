@extends('layouts.textbook')

@section('title','Activation Required')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-sm-offset-3">
                <div class="page-header">
                    <h1>Welcome to Stuvi, {{ $user->first_name }}!</h1>
                </div>

                <div class="container-fluid">
                    <div class="row font-lg">
                        <p>In order to keep our village safe, we need to verify every user.</p>

                        <p>Check your email at <code>{{ $user->primaryEmail->email_address }}</code> and activate your account via the link sent with our
                            welcome email. </p>

                        <p>Problems receiving the email? Check your spam inbox, or <a href="{{ url('user/activate/resend') }}">resend code</a>.</p>
                    </div>
                </div>

            </div>
        </div>

    </div>
@endsection