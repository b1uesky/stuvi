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
                                           href="{{asset('/user/account#')}}">
                                            <i class="fa fa-book"></i>My Bookshelf
                                        </a>
                                    </li>
                                    <li class="side-item">
                                        <a class="side-item-link" id="side-email-link"
                                           href="{{asset('/user/email')}}">
                                            <i class="fa fa-envelope"></i>Email
                                        </a>
                                    </li>
                                    <li class="side-item">
                                        <a class="side-item-link" id="side-notification-link"
                                           href="{{asset('/user/account#')}}">
                                            <i class="fa fa-envelope"></i>Notification
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
