{{--User Account Settings page--}}

@extends('layouts.textbook')

@section('title','Account Settings - '.Auth::user()->first_name.' '.Auth::user()->last_name)

@section('content')
        <div class="container">
            <div class="row">
                <ol class="breadcrumb">
                    <li><a href="{{ url('textbook') }}">Home</a></li>
                    <li class="active">Account settings</li>
                </ol>
            </div>

            <div class="row page-content">
                {{-- Left nav--}}
                <div class="col-md-3 col-sm-4">
                    <ul class="nav nav-pills nav-stacked">
                        <li role="presentation"><a href="{{ url('user/profile') }}">Profile Settings</a></li>
                        <li role="presentation" class="active"><a href="{{ url('user/account') }}">Account Settings</a></li>
                        <li role="presentation"><a href="{{ url('user/email') }}">Email Settings</a></li>
                        <li role="presentation"><a href="{{ url('user/bookshelf') }}">Bookshelf</a></li>
                    </ul>
                </div>

                {{-- Right content --}}
                <div class="col-md-6 col-sm-8">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Change password</h3>
                        </div>
                        <div class="panel-body">
                            <div class="container-fluid">
                                <form role="form" method="POST" action="/user/account/password/reset">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                    <!-- Change password...current password -->
                                    <div class="form-group">
                                        <label>Current password</label>
                                        <input type="password" class="form-control" name="current_password">
                                    </div>

                                    <!-- New password -->
                                    <div class="form-group">
                                        <label>New password</label>
                                        <input type="password" class="form-control" name="new_password">
                                    </div>

                                    <!-- Confirmed New password -->
                                    <div class="form-group">
                                        <label>Confirm new password</label>
                                        <input type="password" class="form-control" name="new_password_confirmation">
                                    </div>

                                    <button type="submit" class="btn btn-primary">Update password</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
@endsection