@extends('app')
<head>
    <link href="{{ asset('/css/login.css') }}" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="{{asset('js/bootstrap.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('/js/login.js')}}" type="text/javascript"></script>
</head>
@section('content')
    <div class="container-fluid">
        <img src="{{asset('/img/stuvi-logo.png')}}" class="img-responsive">
        <div class="row vertical-center">
            <div class="col-sm-6 col-sm-offset-3">
                <div class="container" id="form-container">
                    <ul class="nav nav-tabs nav-justified" role="tablist" id="tabs">
                        <li role="presentation" class="active" id="login-tab"><a href="#login-body" aria-controls="login-body" role="tab" data-toggle="tab">Log In</a></li>
                        <li role="presentation" id="signup-tab"><a href="#signup-body" aria-controls="signup-body" role="tab" data-toggle="tab">Sign Up</a></li>
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
                        <div class="tab-pane active" id="login-body">
                            <form class="form-horizontal login-form" role="form" method="POST" action="{{ url('/auth/login') }}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <input type="email" class="form-control" name="email" placeholder="Email" value="{{ old('email') }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <input type="password" class="form-control" name="password" placeholder="Password">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="remember"> Remember Me
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary login-button">Login</button>
                                        <a class="btn btn-link" id="forgot-password" href="{{ url('/password/email') }}">
                                            Forgot Your Password?
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane" id="signup-body">
                            <form class="form-horizontal" role="form" method="POST" action="{{ url('/auth/register') }}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">\

                                <div class="form-group">
                                    <div class="col-md-12">
                                        <input type="text" class="form-control" name="first_name" placeholder="First Name" value="{{ old('first_name') }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <input type="text" class="form-control" name="last_name" placeholder="Last Name" value="{{ old('last_name') }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <input type="email" class="form-control" name="email" placeholder="Email" value="{{ old('email') }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <input type="password" class="form-control" name="password" placeholder="Password">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <input type="number" class="form-control" name="phone_number" placeholder="Phone Number" value="{{ old('phone_number') }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-6">
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
