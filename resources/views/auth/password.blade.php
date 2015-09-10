{{-- Forgot Password Page --}}

@extends('layouts.textbook')

@section('title','Forgot Password')

@section('content')

<div class="container">
	<div class="row">
		<div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">

            <div class="page-header">
                <h1>Forgot password</h1>
            </div>

            <form method="POST" action="{{ url('/password/email') }}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="form-group">
                    <label>Email</label>

                    <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                </div>

                <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="Submit">
                </div>
            </form>

		</div>
	</div>
</div>
@endsection
