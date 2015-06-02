@extends('app')
    <head>
        <title> </title>
        <link href="{{ asset('/css/profile.css') }}" rel="stylesheet">
    </head>

@section('content')

    <div class = "container-fluid bg" id = "nopad">
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
                </div>

                <div class="span2">
                    <div class="btn-group">
                        <a class="btn btn-info" href="#">
                            Edit Profile
                        </a>
                    </div>
                </div>
            </div>
        </div>

@endsection