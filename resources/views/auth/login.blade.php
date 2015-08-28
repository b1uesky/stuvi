@extends('layouts.login-register')

@section('title', 'Login & Register')

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

    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-sm-offset-3">

                <div class="container-fluid container-login-signup">
                    <img src="{{asset('/img/logo-new-center.png')}}" class="img-responsive center-block">

                    <ul class="nav nav-tabs nav-justified" role="tablist">
                        <!-- login -->
                        <li role="presentation" class="{{ $loginActive }}">
                            <a href="#login-body" aria-controls="login-body" role="tab" data-toggle="tab">Login</a>
                        </li>
                        <!-- signup -->
                        <li role="presentation" class="{{ $signupActive }}">
                            <a href="#signup-body" aria-controls="signup-body" role="tab" data-toggle="tab">Sign Up</a>
                        </li>
                    </ul>

                    <br>

                    <div class="tab-content">
                        <div id="login-body" class="tab-pane {{ $loginActive }}">
                            <form method="POST" action="{{ url('/auth/login') }}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <!-- email -->
                                <div class="form-group">
                                    <label class="sr-only" for="login-email">Email address</label>
                                    <input type="email" class="form-control" name="email" placeholder="Email address" value="{{ old('email') }}">
                                </div>
                                <!-- password -->
                                <div class="form-group">
                                    <label class="sr-only" for="login-password">Password</label>
                                    <input type="password" class="form-control" name="password" placeholder="Password">
                                </div>
                                <!-- remember -->
                                <div class="form-group">
                                    <label for="remember-me-box">
                                        <input type="checkbox" name="remember"> Remember Me
                                    </label>

                                    <div class="pull-right">
                                        <a href="{{ url('/password/email') }}">Forgot Your Password?</a>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary btn-block">Login</button>
                            </form>
                        </div>

                        <div id="signup-body" class="tab-pane {{ $signupActive }}">
                            <form method="POST" action="{{ url('/auth/register') }}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <!-- first name -->
                                <div class="form-group">
                                    <label class="sr-only">First name</label>
                                    <input type="text" class="form-control" name="first_name" placeholder="First Name" value="{{ old('first_name') }}">
                                </div>
                                <!-- last name -->
                                <div class="form-group">
                                    <label class="sr-only">Last name</label>
                                    <input type="text" class="form-control" name="last_name" placeholder="Last Name" value="{{ old('last_name') }}">
                                </div>
                                <!-- email -->
                                <div class="form-group">
                                    <label class="sr-only">Email address</label>
                                    <input type="email" class="form-control" name="email" placeholder="Email (.edu required)" value="{{ old('email') }}">
                                </div>
                                <!-- password -->
                                <div class="form-group">
                                    <label class="sr-only">Password</label>
                                    <input type="password" class="form-control" name="password" placeholder="Password">
                                </div>
                                <!-- phone number -->
                                <div class="form-group">
                                    <label class="sr-only">Phone Number</label>
                                    <input type="tel" class="form-control" name="phone_number" placeholder="Phone Number" value="{{ old('phone_number') }}">
                                </div>
                                <!-- school -->
                                <div class="form-group">
                                    <select class="form-control selectpicker" name="university_id">
                                        <label class="sr-only" for="register-uni">University</label>
                                        <option id="register-uni" selected disabled>Select a university</option>
                                        @foreach($universities as $university)
                                            <option value="{{ $university->id }}">{{ $university->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <small>By signing up, you agree to Stuvi's <a href="{{url('/tos')}}" target="_blank" > Terms of Service</a>
                                        and <a href="{{url('/privacy')}}" target="_blank"> Privacy Notice</a>.</small>
                                </div>
                                <!-- sign up button-->
                                <button type="submit" class="btn btn-primary btn-block">Sign Up</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection

