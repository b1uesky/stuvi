@extends('layouts.textbook')

@section('title','Reset your password')

@section('content')

<div class="container-fluid">
	<div class="row row-main">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Reset Password</div>
				<div class="panel-body">

					<form class="form-horizontal" role="form" method="POST" action="{{ url('/password/reset') }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<input type="hidden" name="token" value="{{ $token }}">

						<div class="form-group">
							<label class="col-md-4 control-label" for="email-input">E-Mail Address</label>
							<div class="col-md-6">
								<input type="email" class="form-control" name="email" value="{{ old('email') }}" id="email-input">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label" for="password-input">Password</label>
							<div class="col-md-6">
								<input type="password" class="form-control" name="password" id="password-input">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label" for="password-confirm-input">Confirm Password</label>
							<div class="col-md-6">
								<input type="password" class="form-control" name="password_confirmation" id="password-confirm-input">
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary">
									Reset Password
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
