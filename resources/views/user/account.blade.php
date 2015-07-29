{{--User Account Settings page--}}

@extends('app')

@section('title','Account Settings - '.Auth::user()->first_name.' '.Auth::user()->last_name)

@section('css')
    <link href="{{ asset('/css/user_account.css') }}" rel="stylesheet">
@endsection

@section('content')
    <!-- User template has the second nav bar and the profile side bar -->
    @include('user-template')
            <!-- right side bar-->
    <div class="col-md-9">
        <div class="profile-content">

            @if (Session::has('password_reset_success'))
                <div class="alert alert-success" id="message">{{ Session::get('password_reset_success') }}</div>
            @elseif (Session::has('password_reset_error'))
                <div class="alert alert-danger" id="message">{{ Session::get('password_reset_error') }}</div>
            @endif

            <!-- Account Settings -->
            <h1>Account Settings</h1>
            <!-- change account info -->
            <div class="container col-md-11 account-edit">
                <h3>Change Password</h3>
                <hr id="line">
                <form class="form-horizontal" role="form" method="POST" action="/user/account/password/reset">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <!-- Change password...current password -->
                    <div class="form-group">
                        <label class="control-label col-sm-3" for="pwd">Current Password:</label>

                        <div class="col-sm-6">
                            <input type="password" class="form-control" name="current_password" id="pwd">
                        </div>
                        @if (Session::has('password_validation_error'))
                            @foreach (Session::get('password_validation_error')->get('current_password') as $err)
                                <div class="alert alert-warning" id="message">{{ $err }}</div>
                            @endforeach
                        @endif
                    </div>
                    <!-- New password -->
                    <div class="form-group">
                        <label class="control-label col-sm-3" for="new-pwd">New Password:</label>

                        <div class="col-sm-6">
                            <input type="password" class="form-control" name="new_password" id="new-pwd">
                        </div>
                        @if (Session::has('password_validation_error'))
                            @foreach (Session::get('password_validation_error')->get('new_password') as $err)
                                <div class="alert alert-warning" id="message">{{ $err }}</div>
                            @endforeach
                        @endif
                    </div>
                    <!-- Confirmed New password -->
                    <div class="form-group">
                        <label class="control-label col-sm-3" for="new-pwd">Confirm New Password:</label>

                        <div class="col-sm-6">
                            <input type="password" class="form-control" name="new_password_confirmation" id="new-pwd">
                        </div>
                    </div>
                    <!-- Save changes button -->
                    <div class="form-group">
                        <div class=" col-sm-offset-3 col-sm-6">
                            <button id="save-info-btn" type="submit" class="btn primary-btn">Update Password
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{--need these closing tags--}}
    </div>
    </div>
    </div>
@endsection

        <!-- inserted at the end of app -->
@section('javascript')
    <script src="{{asset('/js/maskedinput/jquery.maskedinput.min.js')}}"></script>
    <script src="{{asset('/js/user/account.js')}}" type="text/javascript"></script>
@endsection