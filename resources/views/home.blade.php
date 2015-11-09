@extends('layouts.textbook')
@section('description', "Student Village, college service provider")
@section('title', 'Boston Textbook Marketplace & More Coming Soon!')

@section('textbook-header')
@overwrite

@section('content')

    <div class="container-fluid container-bg">

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
    <section class="intro bg-white">
        <div class="jumbotron">
            <div class="container">
                <div class="row">
                    <div class="col-md-9 col-sm-8">
                        <h2>What is Stuvi?</h2>
                        <p>Stuvi is a marketplace built for college students, by college students. We're here to provide relevant services to help you succeed at school, and we're launching here in Boston, Massachusetts!</p>
                        <p><a class="btn btn-default btn-lg" href="{{ url('/about/') }}" role="button">Learn more</a></p>
                    </div>

                    {{-- Login/Signup form --}}
                    <div class="col-md-3 col-sm-4">
                        <ul class="nav nav-tabs nav-justified nav-underline">
                            <li class="active"><a href="#signup" data-toggle="tab">Sign up</a></li>
                            <li><a href="#login" data-toggle="tab">Login</a></li>
                        </ul>

                        <br>

                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="signup">
                                <form action="{{ url('auth/register') }}" method="post">
                                    {{ csrf_field() }}

                                    <!-- first name -->
                                    <div class="form-group">
                                        <label class="sr-only">First name</label>
                                        <input type="text" class="form-control" name="first_name" placeholder="First name"
                                               value="{{ old('first_name') }}">
                                    </div>
                                    <!-- last name -->
                                    <div class="form-group">
                                        <label class="sr-only">Last name</label>
                                        <input type="text" class="form-control" name="last_name" placeholder="Last name"
                                               value="{{ old('last_name') }}">
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
                                <form action="{{ url('/auth/login') }}" method="post">
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
                </div>
            </div>
        </div>
    </section>

    {{-- How it works --}}
    <section>
        <div class="jumbotron">
            <div class="container">
                <h2 class="text-center">How it works</h2>
            </div>
        </div>
    </section>

    {{-- Features --}}
    <section>
        <div class="jumbotron">
            <div class="container">
                <h2 class="text-center">We made it easy</h2>
            </div>
        </div>
    </section>

@endsection
