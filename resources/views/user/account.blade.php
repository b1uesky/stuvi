@extends('app')
    <head>
        <title>Stuvi - Account</title>
        <link href="{{ asset('/css/account.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="{{asset('/css/user-bar.css')}}"
    </head>

@section('content')

    <!-- top bar -->
    <div class="container-fluid" id = "user-bar">
        <ul class="nav nav-tabs nav-justified" role="tablist">
            <li><a href="{{url('/user/profile')}}">Profile</a></li>
            <li class = "active"><a href="{{url('/user/account')}}">Account</a></li>
            <li><a href="#">Orders</a></li>
            <li class = "disabled"><a href="#">Clubs</a></li>
            <li class = "disabled"><a href="#">Groups</a></li>
        </ul>
    </div>

    <div class = "container-fluid bg" id = "pad">
        <div class = "container pad"><h1>My Account</h1></div>
        <div class = "container jumbotron span8 col-offset-2 pad" id = "accJumbotron">
            <h3>Quick Links</h3>
            <hr id="hr1">
            <ul>
                <li><a href="#">Account Settings</a></li>
                <li><a href="#">Messages</a></li>
                <li><a href="#">My Courses</a></li>
                <li><a href="#">Forgot your password?</a></li>

            </ul>



        </div>


    </div>

@endsection