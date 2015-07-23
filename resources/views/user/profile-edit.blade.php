{{--Edit Profile page--}}

@extends('app')
@section('title', 'Edit Profile - '.Auth::user()->first_name.' '.Auth::user()->last_name)

@section('css')
    <link href="{{ asset('/css/user_profileEdit.css') }}" rel="stylesheet">
    @endsection

    @section('content')
            <!-- User template has the second nav bar and the profile side bar -->
    @include('user-template')
    <div class="col-md-9">
        <div class="profile-content">
            <!-- right box -->
            <div class="container col-xs-12 col-md-9" id="profile-details">
                <h1>Edit your Profile</h1>
                <hr>
                <!-- divider line -->
                <div class="container col-md-20 edit-pro">
                    <form action="{{url('/user/store-profile')}}}" class="form-horizontal" role="form">

                        <!-- personal info -->
                        <h4 class="edit-pro-labels">Personal Information</h4>

                        <!-- Sex -->
                        <div class="form-group" id="sex">
                            <label class="control-label col-sm-3">Sex</label>

                            <div class="col-sm-6 align">
                                @if($profile == null or $profile->sex == 'Male')
                                    <select name="sex">
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                    </select>
                                @else
                                    <select name="sex">
                                        <option value="female">Female</option>
                                        <option value="male">Male</option>
                                    </select>
                                @endif
                            </div>
                        </div>

                        <!-- birthday -->
                        <div class="form-group">
                            <label class="control-label col-sm-3" for="birthday">Birthday</label>

                            <div class="col-sm-6">
                                <input type="date" class="form-control" name="birth" id="birthday"
                                       value={{ $profile->birthday or "MM/DD/YYYY"}}>
                            </div>
                        </div>

                        <!-- title -->
                        <div class="form-group">
                            <label class="control-label col-sm-3" for="title">Title:</label>

                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="title" id="title"
                                       value={{$profile->title or ""}}>
                            </div>
                        </div>


                        <!-- Bio / About me -->
                        <div class="form-group">
                            <label class="control-label col-sm-3" for="bio">Bio/About me</label>

                            <div class="col-sm-6">
                                <textarea id="bio" class="form-control" rows="4" cols="50">
                                    {{$profile -> bio or "Tell us your darkest, deepest secret"}}
                                </textarea>
                            </div>
                        </div>
                        <!-- education -->
                        <h4 class="edit-pro-labels">Education Information</h4>
                        <!-- School -->
                        <div class="form-group">
                            <label class="control-label col-sm-3" for="school">School/University</label>

                            <div class="col-sm-6">
                                <textarea class="form-control" rows="1" cols="50" readonly>{{$school}}</textarea>
                            </div>
                        </div>
                        <!-- Grad -->
                        <div class="form-group">
                            <label class="control-label col-sm-3" for="grad">Expected Graduation</label>

                            <div class="col-sm-6 col-sm-offset-0">
                                <input type="date" class="form-control" name="grad" id="grad"
                                       value={{$profile->graduation_date or "MM/YYYY"}}>
                            </div>
                        </div>
                        <!-- Area of Study / Major -->
                        <div class="form-group">
                            <label class="control-label col-sm-3" for="major">Area of Study/Major</label>

                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="major" id="major"
                                       value="{{$profile->major or ""}}">
                            </div>
                        </div>

                        <!-- links -->
                        <h4 class="edit-pro-labels">Links</h4>
                        <!-- facebook -->
                        <div class="form-group">
                            <label class="control-label col-sm-3" for="facebook">Facebook URL</label>

                            <div class="col-sm-6">
                                <input type="url" class="form-control" name="facebook" id="facebook"
                                       value={{$profile->facebook or "https://www.facebook.com/"}}>
                            </div>
                        </div>
                        <!-- Twitter -->
                        <div class="form-group">
                            <label class="control-label col-sm-3" for="Twitter">Twitter Handle:</label>

                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="twitter" id="twitter"
                                       value={{$profile->twitter or "@"}}>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3" for="linkedin">LinkedIn URL</label>

                            <div class="col-sm-6">
                                <input type="url" class="form-control" name="linkedin" id="linkedin"
                                       value={{$profile->linkedin or "https://www.linkedin.com/in/"}}>
                            </div>
                        </div>
                        <!-- website -->
                        <div class="form-group">
                            <label class="control-label col-sm-3" for="website">Website URL</label>

                            <div class="col-sm-6">
                                <input type="url" class="form-control" name="site" id="site"
                                       value={{$profile->website or "http://"}}>
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
