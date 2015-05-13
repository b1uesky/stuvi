@extends('app')
<head>
    <link href="{{ asset('/css/login.css') }}" rel="stylesheet">
</head>
@section('content')
    <div class="container-fluid">
        <img src="{{asset('/img/stuvi-logo.png')}}" class="img-responsive">
        <div class="row vertical-center">
            <div class="col-sm-6 col-sm-offset-3">
                <div class="container" id="form-container">
                    <ul class="nav nav-tabs nav-justified" role="tablist">
                        <li role="presentation" class="active"><a href="#" aria-controls="home" role="tab" data-toggle="tab">Log In</a></li>
                        <li role="presentation"><a href="#" aria-controls="profile" role="tab" data-toggle="tab">Sign Up</a></li>
                    </ul>
                    {{--<div class="panel-heading" id="login-heading">--}}
                        {{--<ul class="nav nav-tabs">--}}
                            {{--<li class="active"><a href="#">Log in</a></li>--}}
                            {{--<li><a href="#">Sign up</a></li>--}}
                        {{--</ul>--}}
                    {{--</div>--}}
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <strong>Whoops!</strong> There were some problems with your input.<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="tab-content">
                        <div class="tab-pane" id="login-body">
                            <form class="form-horizontal login-form" role="form" method="POST" action="{{ url('/auth/login') }}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                <div class="form-group">
                                    <label class="col-md-4 control-label">E-Mail Address</label>

                                    <div class="col-md-6">
                                        <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 control-label">Password</label>

                                    <div class="col-md-6">
                                        <input type="password" class="form-control" name="password">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-4">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="remember"> Remember Me
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-4">
                                        <button type="submit" class="btn btn-primary login-button">Login</button>

                                        <a class="btn btn-link" id="forgot-password" href="{{ url('/password/email') }}">Forgot
                                            Your Password?</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane active" id="signup-body">
                            <form class="form-horizontal" role="form" method="POST" action="{{ url('/auth/register') }}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                <div class="form-group">
                                    <label class="col-lg-4 control-label">First Name</label>
                                    <div class="col-lg-6">
                                        <input type="text" class="form-control" name="first_name" value="{{ old('first_name') }}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-4 control-label">Last Name</label>
                                    <div class="col-lg-6">
                                        <input type="text" class="form-control" name="last_name" value="{{ old('last_name') }}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-4 control-label">E-Mail Address</label>
                                    <div class="col-lg-6">
                                        <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-4 control-label">Password</label>
                                    <div class="col-lg-6">
                                        <input type="password" class="form-control" name="password">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-4 control-label">Phone Number</label>
                                    <div class="col-lg-1">
                                        <input type="number" class="form-control" name="phone_number" value="{{ old('phone_number') }}">
                                    </div>
                                    {{--<span>(Optional)</span>--}}
                                </div>

                                <div class="form-group">
                                    <div class="col-lg-6 col-lg-offset-4">
                                        <button type="submit" class="btn btn-primary login-button">Register</button>
                                    </div>
                                </div>

                                {{--<div class="form-group">--}}
                                {{--<label class="col-md-4 control-label">Username</label>--}}
                                {{--<div class="col-md-6">--}}
                                {{--<input type="text" class="form-control" name="username" value="{{ old('username') }}">--}}
                                {{--</div>--}}
                                {{--</div>--}}

                                {{--<div class="form-group">--}}
                                {{--<label class="col-md-4 control-label">Confirm Password</label>--}}
                                {{--<div class="col-md-6">--}}
                                {{--<input type="password" class="form-control" name="password_confirmation">--}}
                                {{--</div>--}}
                                {{--</div>--}}
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
