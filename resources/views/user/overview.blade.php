{{--User Profile page--}}


{{-- Variables --}}
<?php
$first_name =   Auth::user()->first_name;
$last_name  =   Auth::user()->last_name;
$major      =   Auth::user()->profile->major;
$fb         =   Auth::user()->profile->facebook;
$linkedin   =   Auth::user()->profile->linkedin;
$twitter    =   Auth::user()->profile->twitter;
$website    =   Auth::user()->profile->website;
?>


@extends('app')
@section('title', 'Profile - '.$first_name.' '.$last_name )

@section('css')
    <link href="{{ asset('/css/user_profile.css') }}" rel="stylesheet">
@endsection

@section('content')
    <!-- User template has the second nav bar and the profile side bar -->
    @include('user-template')
            <div class="col-md-9">
                <div class="profile-content">
                    <!-- right box -->
                    <div class="container col-xs-12 col-md-12" id = "profile-details">
                        <h2 id="profile-name">{{ $first_name }} {{ $last_name }}
                            <small id="profile-title">{{Auth:: user()->profile->title}}</small>
                        </h2>
                        <p>{{Auth::user()->profile->bio}}</p>
                        <table class="table" id="profile-info-table">
                            <tr id="profile-school">
                                <td><i class="fa fa-graduation-cap"></i> School</td>
                                <td>{{ Auth::user()->university->name }}</td>
                            </tr>
                            @if($major != "")
                                <tr id="profile-major">
                                    <td><i class="fa fa-pencil"></i>&nbsp;&nbsp;Area of Study</td>
                                    <td>{{$major}}</td>
                                </tr>
                            @endif
                            @if($fb != "https://www.facebook.com/" and $fb != "")
                                <tr id="profile-fb">
                                    <td><i class="fa fa-facebook-square"></i>&nbsp;&nbsp;Facebook Profile</td>
                                    <td><a href="{{$fb}}">{{$fb}}</a></td>
                                </tr>
                            @endif
                            @if($twitter != "@" and $twitter != "" )
                                <tr id="profile-twitter">
                                    <td><i class="fa fa-twitter-square"></i>&nbsp;&nbsp;Twitter Profile</td>
                                    <td><a href="https://twitter.com/{{substr($twitter,1)}}">{{$twitter}}</a></td>
                                </tr>
                            @endif
                            @if($linkedin != "https://www.linkedin.com/in/" and $linkedin != "")
                                <tr id="profile-linkedin">
                                    <td><i class="fa fa-linkedin-square"></i>&nbsp;&nbsp;LinkedIn Profile</td>
                                    <td><a href="{{$linkedin}}">{{$linkedin}}</a></td>
                                </tr>
                            @endif
                            @if($website != "https://" and $website != "")
                                <tr id="profile-website">
                                    <td><i class="fa fa-globe"></i>&nbsp;&nbsp;Website</td>
                                    <td><a href="{{$website}}">{{$website}}</a></td>
                                </tr>
                            @endif
                        </table>

                            <!-- User Stats -->
                        <h2 id = "details"><i class="fa fa-bar-chart"></i>
                            User Stats
                        </h2>
                                <div class="table-responsive">
                                    <table class="table table-condensed">
                                        <!-- joined -->
                                        <tr id ="details-joined">
                                            <td><i class="fa fa-user-plus"></i>
                                                <b> Joined: </b></td>
                                            <td>{{ date("m/d/Y", strtotime(Auth::user()->created_at)) }}</td>
                                            <td></td>
                                        </tr>
                                        <!-- books sold -->
                                        <tr id="details-books-sold">
                                            <td><i class="fa fa-share"></i>
                                                    <b> Books Sold: </b></td>
                                            <td>{{ $num_books_sold }}</td>
                                            <td></td>
                                        </tr>
                                        <!-- books purchased -->
                                        <tr id="details-books-purchased">
                                            <td><i class="fa fa-reply"></i>
                                                <b> Books Purchased: </b></td>
                                            <td>{{ $num_books_bought }}</td>
                                            <td></td>
                                        </tr>
                                    </table>
                                </div>  <!-- end user stats -->
                            </div>
                            <!-- books selling -->

                        </div>
            <!-- needed to end user bar -->
                     </div>
                </div>
            </div>
        </div>
    </div>

@endsection

<!-- inserted at the end of app -->
@section('javascript')
    <script type="text/javascript" src="{{asset('js/user/profile.js')}}"></script>
@endsection
