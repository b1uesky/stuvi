@extends('layouts.textbook')
@section('description', "Student Village, college service provider")
@section('title', 'Boston Textbook Marketplace & More Coming Soon!')

@section('textbook-header')
@overwrite

@section('content')

    <div class="container-fluid container-bg">
        <!-- Background image: <a href="http://www.freepik.com">Designed by Freepik</a> -->

        <div class="container container-top-half">

            <div class="va-container va-container-h va-container-v">
                <div class="va-middle text-center">
                    <h1 class="header-text">Stuvi</h1>
                    <p class="lead tagline">Find the right textbook for you.</p>
                </div>
            </div>

            <div class="container-searchbar center-block">
                @include('includes.textbook.omni-searchbar')
            </div>

        </div>
    </div>

    <!-- Intro -->
    <section id="intro">
        <div class="jumbotron">
            <div class="container">
                <div class="row">
                    {{--<div class="text-center">--}}
                        {{--<h2>What is Stuvi?</h2>--}}
                        {{--<p>Stuvi is a marketplace built for college students, by college students. To help you succeed at school, we're launching our textbook trading service here in Boston!</p>--}}
                        {{--<a class="btn btn-default btn-lg" href="{{ url('/about/') }}" role="button">Learn more</a></p>--}}
                    {{--</div>--}}


                    @if(Auth::guest())
                        <div class="col-lg-9 col-md-8 col-sm-7">
                            <h2>What is Stuvi?</h2>
                            <p>Stuvi is a marketplace built for college students, by college students. To help you succeed at school, we're launching our textbook trading service here in Boston!</p>
                            {{--<p><a class="btn btn-default btn-lg" href="{{ url('/about/') }}" role="button">Learn more</a></p>--}}
                        </div>

                         {{--Login/Signup form--}}
                        <div class="col-lg-3 col-md-4 col-sm-5">
                            <ul class="nav nav-tabs nav-justified nav-underline">
                                <li class="active"><a href="#signup" data-toggle="tab">Sign up</a></li>
                                <li><a href="#login" data-toggle="tab">Login</a></li>
                            </ul>

                            <br>

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="signup">
                                    <form action="{{ url('auth/register') }}" method="post" id="home-signup-form">
                                        {{ csrf_field() }}

                                        <div class="form-group row">
                                            <!-- first name -->
                                            <div class="col-xs-6">
                                                <label class="sr-only">First name</label>
                                                <input type="text" class="form-control" name="first_name" placeholder="First name"
                                                       value="{{ old('first_name') }}">
                                            </div>

                                            <!-- last name -->
                                            <div class="col-xs-6">
                                                <label class="sr-only">Last name</label>
                                                <input type="text" class="form-control" name="last_name" placeholder="Last name"
                                                       value="{{ old('last_name') }}">
                                            </div>
                                        </div>


                                        <!-- email -->
                                        <div class="form-group">
                                            <label class="sr-only">Email address</label>
                                            <input type="email" class="form-control" name="email" placeholder="Email (.edu required)"
                                                   value="{{ old('email') }}">
                                        </div>
                                        <!-- password -->
                                        <div class="form-group">
                                            <label class="sr-only">Password</label>
                                            <input type="password" class="form-control" name="password" placeholder="Password">
                                        </div>
                                        <!-- phone number -->
                                        <div class="form-group">
                                            <label class="sr-only">Phone Number</label>
                                            <input type="tel" class="form-control" name="phone_number" placeholder="Phone number"
                                                   value="{{ old('phone_number') }}">
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

                                        <!-- sign up button-->
                                        <button type="submit" class="btn btn-primary btn-block">Sign Up</button>
                                    </form>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="login">
                                    <form action="{{ url('/auth/login') }}" method="post" id="home-login-form">
                                        {{ csrf_field() }}

                                        <!-- email -->
                                        <div class="form-group">
                                            <label class="sr-only" for="login-email">Email address</label>
                                            <input type="email" class="form-control" name="email" placeholder="Email address"
                                                   value="{{ old('email') }}">
                                        </div>
                                        <!-- password -->
                                        <div class="form-group">
                                            <label class="sr-only" for="login-password">Password</label>
                                            <input type="password" class="form-control" name="password" placeholder="Password">
                                        </div>

                                        <!-- remember -->
                                        <div class="form-group">
                                            <label for="remember-me-box">
                                                <input type="checkbox" name="remember" checked> Remember Me
                                            </label>

                                            <div class="pull-right">
                                                <a href="{{ url('/password/email') }}" class="text-muted">Forgot password?</a>
                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-primary btn-block">Login</button>

                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center">
                            <h2>What is Stuvi?</h2>
                            <p>Stuvi is a marketplace built for college students, by college students. To help you succeed at school, we're launching our textbook trading service here in Boston!</p>
                            {{--<p><a class="btn btn-default btn-lg" href="{{ url('/about/') }}" role="button">Learn more</a></p>--}}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    {{-- How it works --}}
    <section id="how-it-works">
        <div class="jumbotron">
            <div class="container">
                <h2 class="text-center">How it works</h2>
            </div>
        </div>
    </section>

    {{-- Features --}}
    <section id="features">
        <div class="jumbotron">
            <div class="container">
                <h2 class="text-center">We made it easy</h2>
            </div>
        </div>
    </section>

@endsection
