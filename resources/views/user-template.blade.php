{{-- TEMPLATE FOR USER ACCOUNT AND PROFILE
     CONTAINS USER-BAR AND PROFILE SIDE BAR
--}}
<html>
    <body>

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
                                {{--<a href=""><i class="fa fa-github-square"></i></a>--}}
                            </div>
                            {{--                    <div class="profile-userbuttons">
                                                    <button type="button" class="btn btn-success btn-sm">Follow</button>
                                                    <button type="button" class="btn btn-danger btn-sm">Message</button>

                                                </div>--}}
                            <div class="edit">
                                <div class="btn-group">
                                    <a class="btn primary-btn" id="edit-btn" href="{{url('/user/profile-edit')}}">
                                        Edit Profile
                                    </a>
                                </div>
                            </div>
                            <!-- END SIDEBAR BUTTONS -->
                            <!-- SIDEBAR MENU -->
                            <div class="profile-usermenu">
                                <ul class="nav">
                                    <li class="side-item">
                                        <a class="side-item-link active" id="side-profile-link"
                                           href="{{asset('/user/profile')}}">
                                            <i class="fa fa-user"></i>Profile
                                        </a>
                                    </li>
                                    <li class="side-item">
                                        <a class="side-item-link" id="side-account-link"
                                           href="{{asset('/user/account')}}">
                                            <i class="fa fa-cog"></i>Account Settings
                                        </a>
                                    </li>
                                    <li class="side-item">
                                        <a class="side-item-link" id="side-bookshelf-link"
                                           href="{{asset('/user/account')}}">
                                            <i class="fa fa-book"></i>My Bookshelf
                                        </a>
                                    </li>
                                    <li class="side-item">
                                        <a class="side-item-link" id="side-privacy-link"
                                           href="{{asset('/user/account')}}">
                                            <i class="fa fa-user-secret"></i>Privacy
                                        </a>
                                    </li>
                                    <li class="side-item">
                                        <a class="side-item-link" id="side-email-link"
                                           href="{{asset('/user/account')}}">
                                            <i class="fa fa-envelope"></i>Email Notifications
                                        </a>
                                    </li>
                                    <li class="side-item">
                                        <a class="side-item-link" id="side-help-link" href="#">
                                            <i class="fa fa-flag"></i> Help
                                        </a>
                                    </li>
                                    {{--<li class="side-messages">--}}
                                    {{--<a href="#" target="_blank">--}}
                                    {{--<i class="glyphicon glyphicon-envelope"></i>--}}
                                    {{--Messages </a>--}}
                                    {{--</li>--}}
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
