@extends('app')
    <head>
        <title> Stuvi - Profile </title>
        <link href="{{ asset('/css/profile.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="{{asset('/css/user-bar.css')}}"
    </head>

@section('content')


{{--    <div id = "user-bar" class= "container col-md-12">
        @include('user.user-bar')
    </div>--}}

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

{{--
    <div class = "container-fluid bg" id = "pad">

        <div class = "container"><h1>My Profile</h1></div>

        <div class="container well span6 profile">
            <div class="row-fluid">
                <div class="span2" >
                    <img src="http://puu.sh/i8GdU/ae7b5d63a8.png" class="img-circle" height="100px" width="100px">
                </div>

                <!-- TODO: Link profile with backend -->
                <div class="span8">
                    <h3>Jeremy noSc0peH4x420</h3>
                    <h6><b>Email:</b> SupremeLeader@stuvi.com </h6>
                    <h6><b>School/University:</b> Boston University</h6>
                    <h6><b>Expected Graduation:</b> 2070</h6>
                    <h6><b>Area of Study:</b> Compooters</h6>
                    <h6><b>Bio:</b> I have a 3.0 KDR on Club Penguin</h6>
                </div>

                <div class="span2">
                    <div class="btn-group">
                        <a class="btn btn-info" href="#">
                            Edit Profile
                        </a>
                    </div>
                </div>
            </div>
        </div>--}}


<!--
User Profile Sidebar by @keenthemes
        A component of Metronic Theme - #1 Selling Bootstrap 3 Admin Theme in Themeforest: http://j.mp/metronictheme
        Licensed under MIT
        -->
<div class ="container-fluid pro">
    <div class="container">
        <div class="row profile">
            <div class="col-md-3">
                <div class="profile-sidebar">
                    <!-- SIDEBAR USERPIC -->
                    <div class="profile-userpic">
                        <img src="http://puu.sh/i8GdU/ae7b5d63a8.png" class="img-responsive" alt="">
                    </div>
                    <!-- END SIDEBAR USERPIC -->
                    <!-- SIDEBAR USER TITLE -->
                    <div class="profile-usertitle">
                        <div class="profile-usertitle-name">
                            Jeremy noSc0peH4x420
                        </div>
                        <div class="profile-usertitle-job">
                            Developer
                        </div>
                        <h6><b>Email:</b> SupremeLeader@stuvi.com </h6>
                        <h6><b>School/University:</b> Boston University</h6>
                        <h6><b>Expected Graduation:</b> 2070</h6>
                        <h6><b>Area of Study:</b> Compooters</h6>
                        <h6><b>Bio:</b> I have a 3.0 KDR on Club Penguin</h6>
                        <br>
                    </div>
                    <!-- END SIDEBAR USER TITLE -->
                    <!-- SIDEBAR BUTTONS -->
                    <div class="profile-userbuttons">
                        <button type="button" class="btn btn-success btn-sm">Follow</button>
                        <button type="button" class="btn btn-danger btn-sm">Message</button>

                    </div>
                    <div class="edit">
                        <div class="btn-group">
                            <a class="btn btn-info btm-sm" href="#">
                                Edit Profile
                            </a>
                        </div>
                    </div>
                    <!-- END SIDEBAR BUTTONS -->
                    <!-- SIDEBAR MENU -->
                    <div class="profile-usermenu">
                        <ul class="nav">
                            <li class="active">
                                <a href="#">
                                    <i class="glyphicon glyphicon-home"></i>
                                    Overview </a>
                            </li>
                            <li>
                                <a href="{{asset('/user/account')}}">
                                    <i class="glyphicon glyphicon-user"></i>
                                    Account Settings </a>
                            </li>
                            <li>
                                <a href="#" target="_blank">
                                    <i class="glyphicon glyphicon-ok"></i>
                                    Tasks </a>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="glyphicon glyphicon-flag"></i>
                                    Help </a>
                            </li>
                        </ul>
                    </div>
                    <!-- END MENU -->
                </div>
            </div>
            <div class="col-md-9">
                <div class="profile-content">
                    Some user related content goes here...
                </div>
            </div>
        </div>
    </div>
    <br>
    <br>



</div>

@endsection

