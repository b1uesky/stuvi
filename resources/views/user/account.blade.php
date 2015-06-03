@extends('app')


@section('content')
    <head>
        <title>Stuvi - Account</title>
        <link href="{{ asset('/css/account.css') }}" type="text/css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="{{asset('/css/user-bar.css')}}"
    </head>

    <!-- top bar -->
    <div class="container-fluid" id = "user-bar">
        <ul class="nav nav-tabs nav-justified" role="tablist">
            <li class="active"><a href="{{url('/user/profile')}}">Profile</a></li>
            <!-- Account dropdown -->
            <li class="dropdown">
                <a href="#" class="dropdown-toggle tabz" data-toggle="dropdown"> Account<span class="caret"></span> </a>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="{{url('/user/account')}}" class="acc">Account Settings</a></li>
                    <li><a href="#"                        class="acc">Your Courses</a></li>
                    <li><a href="#"                        class="acc">Messages</a></li>
                </ul>
            </li>
            <!-- Textbooks dropdown -->
            <li class="dropdown">
                <a href="#" class="dropdown-toggle tabz" data-toggle="dropdown">Books <span class="caret"></span> </a>
                <ul class="dropdown-menu" role="menu">
                    <li role="presentation" class="dropdown-header">Buy</li>
                    <li><a href="#" data-toggle="tab" class="">Your Orders</a></li>
                    <li><a href="#" data-toggle="tab" class="">Your Wish List</a></li>
                    <li><a href="#" data-toggle="tab" class="">Returns</a></li>
                    <li role="presentation" class="divider"></li>
                    <li role="presentation" class="dropdown-header">Sell</li>
                    <li><a href="#" data-toggle="tab">All Selling</a></li>
                    <li><a href="#" data-toggle="tab">Sold</a></li>
                </ul>
            </li>
            <li class = "disabled"><a href="#">Clubs</a></li>
            <li class = "disabled"><a href="#">Groups</a></li>
        </ul>
    </div>


    <!-- My account container -->
    <div class = "container-fluid bg" id = "pad">

        <div class="container col-md-10">
            <div class = "container"><h1>My Account</h1></div>
            <!-- account container -->
            <div class = "container span6 account">
                <!-- quick links -->
                <div class="container quick-links">
                    <h3>Quick Links</h3>
                    <hr>
                    <ul>
                        <li><a href="#">Messages</a></li>
                        <li><a href="#">Your Courses</a></li>
                        <li><a href="{{url('/password/email')}}">Forgot your password?</a></li>
                    </ul>
                </div>
                <!-- change account information -->
                <div class="container account-edit">
                    <h3>Edit your information</h3>
                    <hr>
                    <form class="form-horizontal" role="form">
                        <!-- First name -->
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="first-name">First name:</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="first-name" id="fname" placeholder="First name">
                            </div>
                        </div>

                        <!-- Last name -->
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="first-name">Last name:</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="last-name" id="lname" placeholder="Last name">
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="email">Email:</label>
                            <div class="col-sm-6">
                                <input type="email" class="form-control" id="email" placeholder="Enter email">
                            </div>
                        </div>
                        <!-- Change password...current password -->
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="pwd">Current Password:</label>
                            <div class="col-sm-6">
                                <input type="password" class="form-control" id="pwd" placeholder="Enter current password">
                            </div>
                        </div>
                        <!-- New password -->
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="new-pwd">New Password:</label>
                            <div class="col-sm-6">
                                <input type="password" class="form-control" id="new-pwd" placeholder="Enter new password">
                            </div>
                        </div>
                        <!-- Save changes button -->
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-6">
                                <button type="submit" class="btn btn-default">Save Changes</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
-



    </div> <!-- My account container end -->


    <script src="{{asset('/js/account.js')}}" type="text/javascript"></script>

@endsection