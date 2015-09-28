{{-- User successfully activated the account --}}

@extends('layouts.textbook')

@section('title','Account activated')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">

                <div class="page-header">
                    <h1>Verification successful</h1>
                </div>

                <p>We will redirect you to our home page shortly...</p>
                <p><a href="{{ url('/') }}">Click here</a> if the page does not refresh.</p>

            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script>
        setTimeout(function() {
            window.location.href = "/"
        }, 2000);
    </script>
@endsection