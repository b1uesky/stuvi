{{--User Account Settings page--}}

@extends('app')

@section('content')
    <head>
        <title> Stuvi - {{ Auth::user()->first_name }} {{ Auth::user()->last_name }} - Account </title>
        <link href="{{ asset('/css/account.css') }}" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="{{asset('/css/user-bar.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('/css/user-profile.css')}}">

    </head>
    <!-- User template has the second nav bar and the profile side bar -->
    @include('user-template')
                <!-- right side bar-->
                <div class="col-md-9">
                    <div class="profile-content">
                        <!-- Account Settings -->
                        <h1>Account Settings</h1>
                        <div class="container col-md-11 quick-links">
                            <!-- Quick Links -->
                            <h3>Quick Links</h3>
                            <hr>
                            <ul>
                                <li><a href="#">Your Courses</a></li>
                                <li><a href="{{url('/password/email')}}">Forgot your password?</a></li>
                            </ul>
                        </div>
                        <!-- change account info -->
                        <div class="container col-md-11 account-edit">
                            <h3>Edit your information</h3>
                            <hr>
                            <form class="form-horizontal" role="form">
                                <!-- First name -->
                                <div class="form-group">
                                    <label class="control-label col-sm-3" for="first-name">First name:</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="first-name" id="fname"
                                               placeholder="First name" value = "{{ Auth::user()->first_name }}">
                                    </div>
                                </div>

                                <!-- Last name -->
                                <div class="form-group">
                                    <label class="control-label col-sm-3" for="first-name">Last name:</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="last-name" id="lname"
                                               placeholder="Last name" value = "{{ Auth::user()->last_name }}">
                                    </div>
                                </div>

                                <!-- Email -->
                                <div class="form-group">
                                    <label class="control-label col-sm-3" for="email">Email:</label>
                                    <div class="col-sm-6">
                                        <input type="email" class="form-control" id="email"
                                               placeholder="Enter email" value="{{ Auth::user()->email }}">
                                    </div>
                                </div>
                                <!-- Phone -->
                                <div class="form-group">
                                    <label class="control-label col-sm-3" for="tel">Phone Number:</label>
                                    <div class="col-sm-6">
                                        <input type="tel" class="form-control" id="phone"
                                               placeholder="Enter phone number" value="{{ Auth::user()->phone_number }}">
                                    </div>
                                </div>
                                <!-- Change password...current password -->
                                <div class="form-group">
                                    <label class="control-label col-sm-3" for="pwd">Current Password:</label>
                                    <div class="col-sm-6">
                                        <input type="password" class="form-control" id="pwd" placeholder="Enter current password">
                                    </div>
                                </div>
                                <!-- New password -->
                                <div class="form-group">
                                    <label class="control-label col-sm-3" for="new-pwd">New Password:</label>
                                    <div class="col-sm-6">
                                        <input type="password" class="form-control" id="new-pwd" placeholder="Enter new password">
                                    </div>
                                </div>
                                <!-- Save changes button -->
                                <div class="form-group">
                                    <div class=" col-sm-offset-3 col-sm-6">
                                        <button id="save-info-btn" type="submit" class="btn btn-default">Save Changes
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- required for active class in nav to work -->
    <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
    <script src="{{asset('/js/account.js')}}" type="text/javascript"></script>


@endsection