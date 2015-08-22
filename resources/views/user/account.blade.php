{{--User Account Settings page--}}

@extends('layouts.textbook')

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

            <!-- Account Settings -->
            <h1>Account Settings</h1>
                <hr>
            <!-- change account info -->
            <div class="container col-md-11 account-edit">
                <h4>Change Password</h4>
                <form class="form-horizontal" role="form" method="POST" action="/user/account/password/reset">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <!-- Change password...current password -->
                    <div class="form-group">
                        <label class="control-label col-sm-3" for="pwd">Current Password:</label>

                        <div class="col-sm-6">
                            <input type="password" class="form-control" name="current_password" id="pwd">
                        </div>
                    </div>

                    <!-- New password -->
                    <div class="form-group">
                        <label class="control-label col-sm-3" for="new-pwd">New Password:</label>

                        <div class="col-sm-6">
                            <input type="password" class="form-control" name="new_password" id="new-pwd">
                        </div>
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