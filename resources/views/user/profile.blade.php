{{--Edit Profile page--}}

@extends('layouts.textbook')
@section('title', 'Edit Profile - '.Auth::user()->first_name.' '.Auth::user()->last_name)

@section('css')
    <link href="{{ asset('/css/user_profileEdit.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('libs/datetimepicker/jquery.datetimepicker.css') }}">
@endsection

@section('content')
        <!-- User template has the second nav bar and the profile side bar -->

    @include('user-template')
    <div class="col-md-9">
        <div class="profile-content">
            <!-- right box -->
            {{--<div class="container col-xs-12 col-md-9" id="profile-details">--}}
            <h1>Profile Settings</h1>
                <hr>
                <!-- divider line -->
            <div class="container col-md-11 edit-pro">
                    <form action="{{url('/user/profile/update')}}" method="POST" class="form-horizontal">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <!-- personal info -->
                        <h4 class="edit-pro-labels">Personal Information</h4>

                        <!-- First name -->
                        <div class="form-group">
                            <label class="control-label col-sm-3" for="first-name">First name:</label>

                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="first_name" id="fname"
                                       placeholder="First name" value="{{ Auth::user()->first_name }}">
                            </div>
                        </div>

                        <!-- Last name -->
                        <div class="form-group">
                            <label class="control-label col-sm-3" for="first-name">Last name:</label>

                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="last_name" id="lname"
                                       placeholder="Last name" value="{{ Auth::user()->last_name }}">
                            </div>
                        </div>

                        <!-- Phone -->
                        <div class="form-group">
                            <label class="control-label col-sm-3" for="tel">Phone Number:</label>

                            <div class="col-sm-6">
                                <input type="tel" class="form-control phone_number" name="phone" id="phone"
                                       value="{{ Auth::user()->phone_number }}">
                            </div>
                        </div>

                        {{-- Paypal Account --}}
                        <div class="form-group">
                            <label class="control-label col-sm-3">PayPal Account:</label>

                            <div class="col-sm-6">
                                <input type="email" class="form-control" name="paypal"
                                       placeholder="PayPal email address" value="{{ $profile->paypal }}">
                            </div>
                        </div>

                        <!-- Sex -->
                        <div class="form-group" id="sex">
                            <label class="control-label col-sm-3" for="choose-sex">Sex</label>

                            <div class="col-sm-6 align">
                                <input type="radio" name="sex" value="male" id="choose-sex"
                                       @if ($profile->sex == 'male')
                                       checked
                                        @endif
                                        > Male
                                <input type="radio" name="sex" value="female" id="choose-sex"
                                       @if ($profile->sex == 'female')
                                       checked
                                        @endif
                                        > Female
                            </div>
                        </div>

                        <!-- birthday -->
                        <div class="form-group">
                            <label class="control-label col-sm-3" for="datetimepicker1">Birthday</label>

                            <div class="col-sm-6">
                                <input class="form-control" id="datetimepicker1" class="date" type="text"
                                       name="birth" value={{$profile->birthday}}>
                            </div>
                        </div>

                        <!-- title -->
                        <div class="form-group">
                            <label class="control-label col-sm-3" for="title">Title:</label>

                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="title" id="title"
                                       value="{{ $profile->title or '' }}">
                            </div>
                        </div>


                        <!-- Bio / About me -->
                        <div class="form-group">
                            <label class="control-label col-sm-3" for="bio">Bio/About me</label>

                            <div class="col-sm-6">
                                <textarea id="bio" name="bio" class="form-control" rows="4"
                                          cols="50">{{$profile->bio or ''}}
                                </textarea>
                            </div>
                        </div>
                        <!-- education -->
                        <h4 class="edit-pro-labels">Education Information</h4>
                        <!-- School -->
                        <div class="form-group">
                            <label class="control-label col-sm-3" for="school">School/University</label>

                            <div class="col-sm-6" id="school">
                                <p class="form-control-static text-muted">{{$school->name}}</p>
                            </div>
                        </div>
                        <!-- Grad -->
                        <div class="form-group">
                            <label class="control-label col-sm-3" for="grad">Expected Graduation</label>

                            <div class="col-sm-6 col-sm-offset-0">
                                <input class="form-control" id="datetimepicker" class="date" type="text" id="grad"
                                       name="grad" value={{$profile->graduation_date}}>
                            </div>
                        </div>
                        <!-- Area of Study / Major -->
                        <div class="form-group">
                            <label class="control-label col-sm-3" for="major">Area of Study/Major</label>

                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="major" id="major"
                                       value="{{$profile->major}}">
                            </div>
                        </div>

                        <!-- links -->
                        <h4 class="edit-pro-labels">Links</h4>
                        <!-- facebook -->
                        <div class="form-group">
                            <label class="control-label col-sm-3" for="facebook">Facebook URL</label>

                            <div class="col-sm-6">
                                <input type="url" class="form-control" name="facebook" id="facebook"
                                       value={{$profile->facebook or ""}}>
                            </div>
                        </div>
                        <!-- Twitter -->
                        <div class="form-group">
                            <label class="control-label col-sm-3" for="twitter">Twitter Handle:</label>

                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="twitter" id="twitter"
                                       value={{$profile->twitter or "@"}}>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3" for="linkedin">LinkedIn URL</label>

                            <div class="col-sm-6">
                                <input type="url" class="form-control" name="linkedin" id="linkedin"
                                       value={{$profile->linkedin or ""}}>
                            </div>
                        </div>
                        <!-- website -->
                        <div class="form-group">
                            <label class="control-label col-sm-3" for="site">Website URL</label>

                            <div class="col-sm-6">
                                <input type="url" class="form-control" name="site" id="site"
                                       value={{$profile->website or ''}}>
                            </div>
                        </div>

                        <!-- Save changes button -->
                        <div class="form-group">
                            <div class=" col-sm-offset-3 col-sm-6">
                                <button id="save-info-btn" type="submit" class="btn btn-primary">Update Profile
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            {{--</div>--}}
        </div>
        <!-- needed to end user bar -->
    </div>
    </div>
    </div>
    </div>
    </div>

@endsection

@section('javascript')
    <script src="{{ asset('libs/jquery.maskedinput/dist/jquery.maskedinput.min.js') }}"></script>
    <script type="text/javascript" src="{{asset('js/user/profile-edit.js')}}"></script>
    <script src="{{ asset('libs/datetimepicker/jquery.datetimepicker.js') }}"></script>
@endsection
