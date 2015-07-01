{{--User Account Settings page--}}

@extends('app')

@section('content')
    <head>
        <title> Stuvi - Wait for Activation </title>
        <link href="{{ asset('/css/user/account.css') }}" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="{{asset('/css/user-bar.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('/css/user-profile.css')}}">

    </head>

    <p>In order to keep our village safe, we need to verify every user.</p>
    <p>So please check your email box and activate your account via the link sent with our welcome email. Thank you!</p>

    <!-- required for active class in nav to work -->
    <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
    <script src="{{asset('/js/account.js')}}" type="text/javascript"></script>


@endsection