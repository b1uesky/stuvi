@extends('login-register')

@section('title', 'Login & Register')

@section('css')
    <link href="{{ asset('/css/auth_login.css') }}" rel="stylesheet">
    <link href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.5/css/bootstrap-select.min.css" rel="stylesheet">
@endsection

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
    <div class="container-fluid content container-main-content">
        <!-- logo -->
        <a href="{{ url('/') }}" id="logo-link"><img src="{{asset('/img/logo-new-center.png')}}" class="img-responsive" id="login-logo"></a>

        <div class="row vertical-center">
            <div class="col-sm-6 col-sm-offset-3">
                <div class="container" id="form-container">
                    <!-- tabs -->
                    <ul class="nav nav-tabs nav-justified" role="tablist" id="tabs">
                        <!-- login tab-->
                        <li role="presentation" class="{{ $loginActive }}" id="login-tab">
                            <a href="#login-body" aria-controls="login-body" role="tab" data-toggle="tab">Login</a>
                        </li>
                        <!-- signup tab-->
                        <li role="presentation" class="{{ $signupActive }}" id="signup-tab">
                            <a href="#signup-body" aria-controls="signup-body" role="tab" data-toggle="tab">Sign Up</a>
                        </li>
                    </ul>
                    <!-- end tabs -->

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
                        <!-- login -->
                        <div class="tab-pane {{ $loginActive }}" id="login-body">
                            <form class="form-horizontal login-form" role="form" method="POST"
                                  action="{{ url('/auth/login') }}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <!-- email -->
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-8 form-space-offset">
                                        <label class="sr-only" for="login-email">Email address</label>
                                        <input type="email" class="form-control input" name="email" id="login-email" placeholder="Email"
                                               value="{{ old('email') }}">
                                    </div>
                                </div>
                                <!-- password -->
                                <div id="password-group" class="form-group">
                                    <label class="sr-only" for="login-password">Password</label>
                                    <div class="col-sm-offset-2 col-sm-8">
                                        <input type="password" class="form-control" name="password" id="login-password" placeholder="Password">
                                    </div>
                                </div>
                                <!-- remember -->
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-8">
                                        <div class="checkbox" id="remember-me">
                                            <label for="remember-me-box">
                                                <input type="checkbox" name="remember" id="remember-me-box"> Remember Me
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <!-- forgot pw -->
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-8">
                                        <button type="submit" class="btn primary-btn submit-btn">Login</button>
                                        <br>
                                        <a class="btn btn-link" id="forgot-password"
                                           href="{{ url('/password/email') }}">Forgot Your Password?</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- sign up -->
                        <div class="tab-pane {{ $signupActive }}" id="signup-body">
                            <form class="form-horizontal" role="form" method="POST" action="{{ url('/auth/register') }}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <!-- first name -->
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-8 form-space-offset">
                                        <label class="sr-only" for="register-first">First name</label>
                                        <input type="text" class="form-control" name="first_name" id="register-first"
                                               placeholder="First Name" value="{{ old('first_name') }}">
                                    </div>
                                </div>
                                <!-- last name -->
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-8">
                                        <label class="sr-only" for="register-last">Last name</label>
                                        <input type="text" class="form-control" name="last_name" id="register-last"
                                               placeholder="Last Name" value="{{ old('last_name') }}">
                                    </div>
                                </div>
                                <!-- email -->
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-8">
                                        <label class="sr-only" for="register-email">Email address</label>
                                        <input type="email" class="form-control" name="email" id="register-email"
                                               placeholder="Email" value="{{ old('email') }}">
                                    </div>
                                </div>
                                <!-- password -->
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-8">
                                        <label class="sr-only" for="register-password">Password</label>
                                        <input type="password" class="form-control" name="password" id="register-password"
                                               placeholder="Password">
                                    </div>
                                </div>
                                <!-- phone number -->
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-8">
                                        <label class="sr-only" for="register-phone">Phone Number</label>
                                        <input type="tel" class="form-control phone_number" name="phone_number" id="register-phone"
                                               placeholder="Phone Number" value="{{ old('phone_number') }}">
                                    </div>
                                </div>
                                <!-- school -->
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-8">
                                        <select class="form-control" name="university_id">
                                            <label class="sr-only" for="register-uni">School</label>
                                            <option id="register-uni" selected disabled>University</option>
                                            @foreach($universities as $university)
                                                <option value="{{ $university->id }}">{{ $university->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <!-- tos statement-->
                                <div class="tos col-sm-offset-2 col-sm-8">
                                    By creating an account, you agree to Stuvi's
                                    <a href="#" data-toggle="modal" data-target=".terms-modal">Terms of Use</a> and
                                    <a href="#" data-toggle="modal" data-target=".privacy-modal"> Privacy Notice</a>.
                                </div>
                                <!-- sign up button-->
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-8">
                                        <button type="submit" class="btn primary-btn submit-btn">Sign Up</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        @include('includes.textbook.tos-privacy-modal')

    </div>

@endsection

@section('javascript')
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.5/js/bootstrap-select.min.js"></script>
@endsection

