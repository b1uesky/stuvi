{{--
    Used in header.blade.php and home.blade.php
    This is the pop-up for login in and sign up  --}}

@section('login-signup-modal')
    <div class="login-signup-modal" style="z-index: 99999;">
        <div class="modal fade login-modal" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="Login">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <!-- close button -->
                        <button type="button" class="close close-modal-btn" data-dismiss="modal" aria-label="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <!-- header -->
                        <h4><i class="fa fa-sign-in"></i> Login</h4>
                    </div>
                    <div class="modal-body">
                        <form role="form"  action="{{ url('/auth/login') }}" method="post" id="form-login">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <!-- email -->
                            <div class="form-group">
                                <label for="login-email"><i class="fa fa-envelope"></i> Email</label>
                                <input type="text" class="form-control" id="login-email" name="email" placeholder="Enter email" required>
                            </div>
                            <!-- password -->
                            <div class="form-group">
                                <label for="login-password"><i class="fa fa-key"></i> Password</label>
                                <input type="password" class="form-control" name="password" id="login-password" placeholder="Enter password" required>
                            </div>
                            <!-- remember me -->
                            <div class="checkbox" id="remember-me">
                                <label for="remember-me-box">
                                    <input id="remember-me-box" type="checkbox" value="" checked>Remember me</label>
                            </div>
                            <button type="submit" class="btn primary-btn submit-btn">Login</button>
                            <i class="fa fa-spinner fa-pulse fa-2x loading"></i>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <p>Not a member? <a data-toggle="modal" href="#signup-modal" data-dismiss="modal">Sign Up</a></p>
                        <a id="forgot-password" href="{{ url('/password/email') }}">Forgot Password?</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- sign up modal -->
        <div class="modal fade signup-modal" id="signup-modal" tabindex="-1" role="dialog" aria-labelledby="SignUp">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <!-- close -->
                        <button type="button" class="close close-modal-btn" data-dismiss="modal" aria-label="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <!-- header -->
                        <h4><i class="fa fa-user-plus"></i> Sign Up</h4>
                    </div>
                    <div class="modal-body">
                        <form role="form" method="POST" id="form-register">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <!-- first name -->
                            <div class="form-group">
                                <label class="sr-only" for="register-first">First Name</label>
                                <input type="text" name="first_name" class="form-control" id="register-first" placeholder="First name">
                            </div>
                            <!-- last name -->
                            <div class="form-group">
                                <label class="sr-only" for="register-last">Last Name</label>
                                <input type="text" name="last_name" class="form-control" id="register-last" placeholder="Last name">
                            </div>
                            <!-- email -->
                            <div class="form-group">
                                <label class="sr-only" for="register-email">Email</label>
                                <input type="email" name="email" class="form-control" id="register-email" placeholder="University email address (.edu required)">
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
                                <select class="form-control" name="university_id" id="register-university">
                                    <option selected disabled>University</option>
                                    @foreach(\App\University::where('is_public', true)->get() as $university)
                                        <option value="{{ $university->id }}">{{ $university->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn primary-btn submit-btn">Sign Up</button>
                            <i class="fa fa-spinner fa-pulse fa-2x loading"></i>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <p>Already a member? <a data-toggle="modal" href="#login-modal" data-dismiss="modal">Login</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@show