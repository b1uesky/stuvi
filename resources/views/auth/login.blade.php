@extends('app2')
<head>
    <link href="{{ asset('/css/auth/login.css') }}" rel="stylesheet">
    <link href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.5/css/bootstrap-select.min.css" rel="stylesheet">
    <title> Stuvi - login & register</title>
</head>

{{--set starting tab based on clicked nav button--}}
{{--the code below is not commented, it's blade syntax for variables--}}
@if (isset($loginType) && $loginType == 'login')
    {{--*/ $loginActive = ' active' /*--}}
    {{--*/ $signupActive = '' /*--}}
@else
    {{--*/ $loginActive = '' /*--}}
    {{--*/ $signupActive = ' active' /*--}}
@endif

@section('content')
    <div class="container-fluid">
        <a href="{{ url('/') }}" id="logo-link"><img src="{{asset('/img/stuvi-logo.png')}}" class="img-responsive"
                                                     id="login-logo"></a>

        <div class="row vertical-center">
            <div class="col-sm-6 col-sm-offset-3">
                <div class="container" id="form-container">
                    <ul class="nav nav-tabs nav-justified" role="tablist" id="tabs">
                        <li role="presentation" class="{{ $loginActive }}" id="login-tab"><a href="#login-body"
                                                                                             aria-controls="login-body"
                                                                                             role="tab"
                                                                                             data-toggle="tab">Login</a>
                        </li>
                        <li role="presentation" class="{{ $signupActive }}" id="signup-tab"><a href="#signup-body"
                                                                                               aria-controls="signup-body"
                                                                                               role="tab"
                                                                                               data-toggle="tab">Sign
                                Up</a></li>
                    </ul>

                    {{-- Messages --}}
                    @if (Session::has('message'))
                        <div class="alert alert-danger">
                            <ul>
                                <li>{{ Session::get('message') }}</li>
                            </ul>
                        </div>
                    @endif

                    {{-- Errors for invalid data --}}
                    @if ($errors->has())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Successfully scheduled a pickup time --}}
                    @if(Session::has('success'))
                        <div class="alert alert-success">{{ Session::get('success') }}</div>
                    @endif
                    <div class="tab-content">
                        <div class="tab-pane {{ $loginActive }}" id="login-body">
                            <form class="form-horizontal login-form" role="form" method="POST"
                                  action="{{ url('/auth/login') }}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                <div class="form-group">
                                    <div class="col-sm-offset-3 col-sm-6 form-space-offset">
                                        <input type="email" class="form-control" name="email" placeholder="Email"
                                               value="{{ old('email') }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-3 col-sm-6">
                                        <input type="password" class="form-control" name="password"
                                               placeholder="Password">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-4 col-sm-6">
                                        <div class="checkbox" id="remember-me">
                                            <label>
                                                <input type="checkbox" name="remember"> Remember Me
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-6">
                                        <button type="submit" class="btn login-button col-sm-offset-5">Login</button>
                                        <a class="btn btn-link col-sm-offset-4" id="forgot-password"
                                           href="{{ url('/password/email') }}">
                                            Forgot Your Password?
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane {{ $signupActive }}" id="signup-body">
                            <form class="form-horizontal" role="form" method="POST"
                                  action="{{ url('/auth/register') }}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                <div class="form-group">
                                    <div class="col-sm-offset-3 col-sm-6 form-space-offset">
                                        <input type="text" class="form-control" name="first_name"
                                               placeholder="First Name" value="{{ old('first_name') }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-3 col-sm-6">
                                        <input type="text" class="form-control" name="last_name" placeholder="Last Name"
                                               value="{{ old('last_name') }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-3 col-sm-6">
                                        <input type="email" class="form-control" name="email" placeholder="Email"
                                               value="{{ old('email') }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-3 col-sm-6">
                                        <input type="password" class="form-control" name="password"
                                               placeholder="Password">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-3 col-sm-6">
                                        <input type="tel" class="form-control" name="phone_number"
                                               placeholder="Phone Number" value="{{ old('phone_number') }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-3 col-sm-6">
                                        <select class="selectpicker" name="university_id">
                                            @foreach($universities as $university)
                                                <option value="{{ $university->id }}">{{ $university->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="tos">
                                    By creating an account, you agree to Stuvi's <a href="#">Term of Use</a> and
                                    <a href="#">Privacy Notice</a>.
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-offset-3 col-sm-6">
                                        <button type="submit" class="btn login-button">Sign Up</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
@endsection


@section('javascript')
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.5/js/bootstrap-select.min.js"></script>
    <script src="{{asset('/js/login.js')}}" type="text/javascript"></script>
@endsection

