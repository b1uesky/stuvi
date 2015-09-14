{{--
    Used in header.blade.php and home.blade.php
    This is the pop-up for login in and sign up  --}}

@section('login-signup-modal')
    <div class="modal fade login-modal spinner-modal" id="login-modal" tabindex="-1" role="dialog"
         aria-labelledby="Login">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <!-- close button -->
                    <button type="button" class="close close-modal-btn" data-dismiss="modal" aria-label="close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <!-- header -->
                    <h4 class="modal-title">Login</h4>
                </div>
                <div class="container-login-alert"></div>
                <div class="modal-body">
                    <form role="form" action="{{ url('/auth/login') }}" method="post" id="form-login">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <!-- email -->
                        <div class="form-group">
                            <label class="sr-only" for="login-email">Email</label>
                            <input type="text" class="form-control" id="login-email" name="email"
                                   placeholder="Email Address" required>
                        </div>
                        <!-- password -->
                        <div class="form-group">
                            <label class="sr-only" for="login-password">Password</label>
                            <input type="password" class="form-control" name="password" id="login-password"
                                   placeholder="Password" required>
                        </div>
                        <div class="form-group">
                            <!-- remember me -->
                            <div class="remember-me checkbox">
                                <label>
                                    <input type="checkbox">Remember me
                                </label>
                            </div>
                            {{-- forgot password --}}
                            <div class="forgot-password pull-right">
                                <a href="{{ url('/password/email') }}">Forgot Password?</a>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">Login</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <div class="text-left">Not a member? <a data-toggle="modal" href="#signup-modal" data-dismiss="modal">Sign Up</a></div>
                </div>
            </div>
        </div>
    </div>
    <!-- sign up modal -->
    <div class="modal fade signup-modal spinner-modal" id="signup-modal" tabindex="-1" role="dialog"
         aria-labelledby="SignUp">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <!-- close -->
                    <button type="button" class="close close-modal-btn" data-dismiss="modal" aria-label="close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <!-- header -->
                    <h4 class="modal-title">Sign Up</h4>
                </div>
                <div class="modal-body">
                    <form role="form" method="POST" id="form-register">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <!-- first name -->
                        <div class="form-group">
                            <label class="sr-only" for="register-first">First Name</label>
                            <input type="text" name="first_name" class="form-control" id="register-first"
                                   placeholder="First name">
                        </div>
                        <!-- last name -->
                        <div class="form-group">
                            <label class="sr-only" for="register-last">Last Name</label>
                            <input type="text" name="last_name" class="form-control" id="register-last"
                                   placeholder="Last name">
                        </div>
                        <!-- email -->
                        <div class="form-group">
                            <label class="sr-only" for="register-email">Email</label>
                            <input type="email" name="email" class="form-control" id="register-email"
                                   placeholder="Email address (.edu)">
                        </div>
                        <!-- password -->
                        <div class="form-group">
                            <label class="sr-only" for="register-password">Password</label>
                            <input type="password" name="password" class="form-control phone_number"
                                   id="register-password" placeholder="Password">
                        </div>
                        <!-- phone number -->
                        <div class="form-group">
                            <label class="sr-only" for="register-phone">Phone Number</label>
                            <input type="tel" name="phone_number" class="form-control" id="register-phone"
                                   placeholder="Phone number">
                        </div>
                        <!-- university -->
                        <div class="form-group">
                            <label class="sr-only" for="register-university">School</label>
                            <select class="form-control selectpicker" name="university_id" id="register-university">
                                <option selected disabled>Select a university</option>
                                @foreach(\App\University::where('is_public', true)->get() as $university)
                                    <option value="{{ $university->id }}">{{ $university->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <small>By signing up, you agree to Stuvi's <a href="{{url('/tos')}}" target="_blank" > Terms of Service</a>
                                and <a href="{{url('/privacy')}}" target="_blank"> Privacy Notice</a>.</small>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Sign Up</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <div class="text-left">Already a member? <a data-toggle="modal" href="#login-modal" data-dismiss="modal">Login</a></div>
                </div>
            </div>
        </div>
    </div>

@show