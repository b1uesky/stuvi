{{--Edit Profile page--}}

@extends('app')
@section('title', 'Profile')

@section('content')
    <head>
        <title> Stuvi - {{ Auth::user()->first_name }} {{ Auth::user()->last_name }} - Edit Profile </title>
        <link href="{{ asset('/css/user/profile-edit.css') }}" rel="stylesheet">
    </head>
    <!-- User template has the second nav bar and the profile side bar -->
    @include('user-template')
                <div class="col-md-9">
                    <div class="profile-content">
                        <!-- right box -->
                        <div class="container col-xs-12 col-md-9" id = "profile-details">
                            <h1>Edit your Profile</h1>
                            <hr> <!-- divider line -->
                            <div class="container col-md-20 edit-pro">
                                <form class="form-horizontal" role="form">

                                    <!-- personal info -->
                                    <h4 class="edit-pro-labels">Personal Information</h4>
                                    <div class="form-group">
                                        <label class="control-label col-sm-3" for="pro-pic">Profile Image:</label>
                                        <div class="col-sm-6 align">
                                            <input type="file" name="image"/>
                                        </div>
                                    </div>

                                    <!-- Sex -->
                                    <div class="form-group" id="sex">
                                        <label class="control-label col-sm-3">Sex</label>
                                        <div class = "col-sm-6 align">
                                            <input class="control-label" type="radio" name="sex" value="1" checked/>
                                            Male
                                            <input class="control-label" type="radio" name="sex" value="2"/> Female
                                        </div>
                                    </div>

                                    <!-- birthday -->
                                    <div class="form-group">
                                        <label class="control-label col-sm-3" for="birthday">Birthday:</label>
                                        <div class="col-sm-6">
                                            <input type="date" class="form-control" name="birth" id="birthday" placeholder="MM/DD/YYYY">
                                        </div>
                                    </div>

                                    <!-- title -->
                                    <div class="form-group">
                                        <label class="control-label col-sm-3" for="birthday">Title:</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" name="title" id="title" placeholder="">
                                        </div>
                                    </div>


                                    <!-- Bio / About me -->
                                    <div class="form-group">
                                        <label class="control-label col-sm-3" for="bio">Bio/About me:</label>
                                        <div class="col-sm-6">
                                            <textarea id="bio" class="form-control" rows="4" cols="50"
                                                      placeholder="Tell us your deepest, darkest secrets.">
                                            </textarea>
                                        </div>
                                    </div>
                                    <!-- education -->
                                    <h4 class="edit-pro-labels">Education Information</h4>
                                    <!-- School -->
                                    <div class="form-group">
                                        <label class="control-label col-sm-3" for="school">School/University:</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" name="school" id="school"
                                                   value = "">
                                        </div>
                                    </div>
                                    <!-- Grad -->
                                    <div class="form-group">
                                        <label class="control-label col-sm-3" for="grad">Expected Graduation:</label>
                                        <div class="col-sm-6 col-sm-offset-0">
                                            <input type="date" class="form-control" name="grad" id="grad" placeholder="MM/YYYY">
                                        </div>
                                    </div>
                                    <!-- Area of Study / Major -->
                                    <div class="form-group">
                                        <label class="control-label col-sm-3" for="major">Area of Study/Major:</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" name="major" id="major">
                                        </div>
                                    </div>

                                    <!-- links -->
                                    <h4 class="edit-pro-labels">Links</h4>
                                    <!-- facebook -->
                                    <div class="form-group">
                                        <label class="control-label col-sm-3" for="facebook">Facebook URL:</label>
                                        <div class="col-sm-6">
                                            <input type="url" class="form-control" name="facebook" id="facebook" value="https://www.facebook.com/">
                                        </div>
                                    </div>
                                    <!-- Twitter -->
                                    <div class="form-group">
                                        <label class="control-label col-sm-3" for="Twitter">Twitter Handle:</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" name="twitter" id="twitter" value="@">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-3" for="linkedin">LinkedIn URL:</label>
                                        <div class="col-sm-6">
                                            <input type="url" class="form-control" name="linkedin" id="linkedin" value="https://www.linkedin.com/in/">
                                        </div>
                                    </div>
                                    <!-- website -->
                                    <div class="form-group">
                                        <label class="control-label col-sm-3" for="website">Website URL:</label>
                                        <div class="col-sm-6">
                                            <input type="url" class="form-control" name="site" id="site" placeholder="http://">
                                        </div>
                                    </div>

                                    <!-- Save changes button -->
                                    <div class="form-group">
                                        <div class=" col-sm-offset-3 col-sm-6">
                                            <button id="save-info-btn" type="submit" class="btn btn-default">Save
                                                Changes
                                            </button>
                                        </div>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
        <!-- needed to end user bar -->
                    </div>
                </div>
             </div>
        </div>
    </div>

@endsection

@section('javascript')
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="{{asset('js/profile-edit.js')}}"></script>
@endsection
