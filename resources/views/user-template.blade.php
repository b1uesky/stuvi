{{-- TEMPLATE FOR USER ACCOUNT AND PROFILE
     CONTAINS USER-BAR AND PROFILE SIDE BAR
--}}

<html>

    <head>
        {{--<title> Stuvi - @yield('title')</title>--}}
        <link rel="stylesheet" type="text/css" href="{{asset('/css/user-bar.css')}}"> 
        <link rel="stylesheet" type="text/css" href="{{asset('/css/user-profile.css')}}">
    </head>

    <body>
    <!-- Second nav bar -->
    @section('user-bar')
        @parent
        <div class="container-fluid" id = "user-bar">
            <ul class="nav nav-tabs nav-justified" role="tablist">
                <!-- Profile -->
                <li id="profile-nav" ><a href="{{url('/user/profile')}}">Profile</a></li>
                <!-- Account dropdown -->
                <li class="dropdown" id="account-nav" >
                    <a href="#" class="dropdown-toggle tabz" data-toggle="dropdown">
                        Account<span class="caret"></span> </a>
                    <ul class="dropdown-menu" role="menu">
                        <li id="acc-settings-nav"><a href="{{url('/user/account')}}" class="acc">Account Settings</a></li>
                        <li id="your-courses-nav"><a href="#"                        class="acc">Your Courses</a></li>
                        <li id="messages-nav"><a href="#"                        class="acc">Messages</a></li>
                    </ul>
                </li> <!-- end account dropdown -->
                <!-- Textbooks dropdown -->
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle tabz" id ="books-nav" data-toggle="dropdown">Books <span class="caret"></span> </a>
                    <ul class="dropdown-menu" role="menu">
                        <li role="presentation" class="dropdown-header">Buy</li>
                        <li><a href="{{url('/order/buyer')}}" class="">Your Orders</a></li>
                        <li><a href="#" class="">Your Wish List</a></li>
                        <li><a href="#" class="">Returns</a></li>
                        <li role="presentation" class="divider"></li>
                        <li role="presentation" class="dropdown-header">Sell</li>
                        <li><a href="#">All Selling</a></li>
                        <li><a href="#">Sold</a></li>
                    </ul>
                </li> <!-- end textbooks dropdown -->
                <li class = "disabled" id="clubs-nav"><a href="#">Clubs</a></li>
                <li class = "disabled" id="groups-nav"><a href="#">Groups</a></li>
            </ul>
        </div> <!-- end user-bar -->
    @show

    @section('profile-bar')

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
                                    {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}
                                </div>
                                <div class="profile-usertitle-job">
                                    Developer
                                </div>
                                <h6><b>Email:</b> {{ Auth::user()->email }}</h6>
                                <h6><b>School/University:</b> Boston University</h6>
                                <h6><b>Expected Graduation:</b> 2070</h6>
                                <h6><b>Area of Study:</b> Compooters</h6>
                                <h6><b>Bio:</b> I have a 3.0 KDR on Club Penguin</h6>
                            </div>
                            <!-- END SIDEBAR USER TITLE -->
                            <!-- SIDEBAR BUTTONS -->

                            <div class="social-media-buttons">
                                <a href=""> <i class="fa fa-facebook-official"></i></a>
                                <a href=""><i class="fa fa-twitter-square"></i></a>
                                <a href=""><i class="fa fa-linkedin-square"></i></a>
                                <a href=""><i class="fa fa-github-square"></i></a>
                            </div>
                            {{--                    <div class="profile-userbuttons">
                                                    <button type="button" class="btn btn-success btn-sm">Follow</button>
                                                    <button type="button" class="btn btn-danger btn-sm">Message</button>

                                                </div>--}}
                            <div class="edit">
                                <div class="btn-group">
                                    <a class="btn btn-info btm-sm" id="edit-but" href="{{url('/user/profile-edit')}}">
                                        Edit Profile
                                    </a>
                                </div>
                            </div>
                            <!-- END SIDEBAR BUTTONS -->
                            <!-- SIDEBAR MENU -->
                            <div class="profile-usermenu">
                                <ul class="nav">
                                    <li class="side-overview" id="pro-overview-nav">
                                        <a href="{{asset('/user/profile')}}">
                                            <i class="glyphicon glyphicon-home"></i>
                                            Overview </a>
                                    </li>
                                    <li class="side-settings" id="pro-acc-nav">
                                        <a href="{{asset('/user/account')}}">
                                            <i class="glyphicon glyphicon-user"></i>
                                            Account Settings </a>
                                    </li>
                                    <li class="side-messages">
                                        <a href="#" target="_blank">
                                            <i class="glyphicon glyphicon-envelope"></i>
                                            Messages </a>
                                    </li>
                                    <li class="side-help">
                                        <a href="#">
                                            <i class="glyphicon glyphicon-flag"></i>
                                            Help </a>
                                    </li>
                                </ul>
                            </div>
                            <!-- END MENU -->
                        </div>
                    </div>

    @show

   <div class="container col-md-9">

        @yield('content')
    </div>
    </body>
    <!-- yes i know it's missing divs -->

</html>
