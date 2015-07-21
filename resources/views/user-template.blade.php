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
                                    <li class="side-overview" id="pro-overview-nav">
                                        <a href="{{asset('/user/profile')}}">
                                            <i class="glyphicon glyphicon-home"></i>
                                            Overview </a>
                                    </li>
                                    <li class="side-settings" id="pro-acc-nav">
                                        <a href="{{asset('/user/account')}}">
                                            <i class="glyphicon glyphicon-user"></i>
                                            Account</a>
                                    </li>
                                    <li class="side-edit-profile" id="pro-edit-nav">
                                        <a href="{{asset('/user/profile-edit')}}">
                                            <i class="glyphicon glyphicon-list-alt"></i>
                                            Profile</a>
                                    </li>
{{--                                    <li class="side-messages">
                                        <a href="#" target="_blank">
                                            <i class="glyphicon glyphicon-envelope"></i>
                                            Messages </a>
                                    </li>
                                    <li class="side-help">
                                        <a href="#">
                                            <i class="glyphicon glyphicon-flag"></i>
                                            Help </a>--}}
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
