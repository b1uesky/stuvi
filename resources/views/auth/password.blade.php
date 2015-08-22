{{-- Forgot Password Page --}}

@extends('layouts.textbook')

@section('title','Forgot Password')

@section('css')
    <link href="{{ asset('/css/auth_login.css') }}" rel="stylesheet">
@endsection

@section('content')

<div class="container-fluid reset-container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2 ">
			<div class="jumbotron" id="password-jumbotron">

                <h2 id="reset-title">Reset your password</h2>
                <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/email') }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div class="form-group form-space-offset">
                        <label class="col-md-4 control-label reset-label" for="email-input">Email Address</label>
                        <div class="col-md-6">
                            <input type="email" class="form-control" name="email" value="{{ old('email') }}" id="email-input">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn primary-btn submit-btn" id="reset-button">
                                Send Password Reset Link
                            </button>
                        </div>
                    </div>
                </form>
			</div>
		</div>
	</div>
</div>
@endsection

@section('javascript')
@endsection
