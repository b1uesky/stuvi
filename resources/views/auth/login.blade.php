@extends('app')
<head>
    <link href="{{ asset('/css/login.css') }}" rel="stylesheet">
</head>
@section('content')
    <div class="container-fluid">
        <div class="row vertical-center">
            <div class="col-sm-6 col-sm-offset-3">
                <div class="panel panel-default" role="tabpanel">
                    <div class="panel-heading" id="login-heading">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#">Log in</a></li>
                            <li><a href="#">Sign up</a></li>
                        </ul>
                    </div>
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
                        <div role="tabpanel" class="tab-pane active" id="login-body">
                            <form class="form-horizontal" id="login-form" role="form" method="POST" action="{{ url('/auth/login') }}">
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
                                        <button type="submit" class="btn btn-primary" id="login-button">Login</button>

                                        <a class="btn btn-link" id="forgot-password" href="{{ url('/password/email') }}">Forgot
                                            Your Password?</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="signup-body">
                            <form class="form-horizontal" id="signup-form" role="form" method="POST" action="{{ url('/auth/register') }}">
                                {{-- try to yield register.blade.php in this div --}}
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
                                        <button type="submit" class="btn btn-primary" id="login-button">Login</button>

                                        <a class="btn btn-link" id="forgot-password" href="{{ url('/password/email') }}">Forgot
                                            Your Password?</a>
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
