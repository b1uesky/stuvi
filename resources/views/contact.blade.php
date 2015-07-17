@extends('app')

@section('title', 'Contact us')

@section('css')
    <link href="{{ asset('/css/contact.css') }}" rel="stylesheet">
@endsection

@section('content')

    <div class="container-fluid background">
        <div class="container-fluid">
            <div class="title-container">
                <h2>Contact Us</h2>
                <p>Please feel free to ask a question or give us feedback</p>
            </div>

            <div class="col-sm-6 contact-form-container">
                <form class="form-horizontal login-form" role="form" method="POST" action="{{ url('/auth/login') }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
                        @if(Auth::guest())
                            <input type="text" class="form-control" placeholder="First Name">
                        @else
                            <input type="text" class="form-control" placeholder="First Name" value="{{ Auth::user()->first_name }}">
                        @endif
                    </div>
                    <div class="form-group">
                        @if(Auth::guest())
                            <input type="text" class="form-control" placeholder="Last Name">
                        @else
                            <input type="text" class="form-control" placeholder="Last Name" value="{{ Auth::user()->last_name }}">
                        @endif
                    </div>
                    <div class="form-group">
                        @if(Auth::guest())
                            <input type="text" class="form-control" placeholder="Email">
                        @else
                            <input type="text" class="form-control" placeholder="Email" value="{{ Auth::user()->email }}">
                        @endif
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" rows="5" placeholder="Message"></textarea>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn primary-btn" id="contact-btn">Submit</button>
                    </div>
                </form>
            </div>

            <div class="col-sm-5 right-container">
                <h3>Contact Details</h3>
                <div class="contact-info-container">
                    <ul class="contact-info">
                        <li><a href="http://bit.ly/1AStBAY" target="_blank"><i class="fa fa-map-marker fa-lg"
                                                                               id="map-marker"></i> Boston, MA</a></li>
                        <li><a href="mailto:official@stuvi.com"><i class="fa fa-envelope-o fa-lg"></i> official@stuvi
                                .com</a></li>
                        <li><a href="https://www.facebook.com/StuviBoston" target="_blank"><i
                                        class="fa fa-facebook fa-lg" id="facebook"></i> Facebook</a></li>
                        <li><a href="https://twitter.com/StuviBoston" target="_blank"><i class="fa fa-twitter fa-lg"></i> Twitter</a></li>
                        <li><a href="https://www.linkedin.com/company/stuvi?trk=biz-companies-cym" target="_blank"><i
                                        class="fa fa-linkedin fa-lg" id="linkedin"></i> LinkedIn</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="testing">
        <button class="btn primary-btn" data-toggle="modal" data-target=".login-modal">Login</button>
        <div class="modal fade login-modal" id="login-modal" tabindex="-1" role="dialog"
             aria-labelledby="Login">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close close-modal-btn" data-dismiss="modal"
                                aria-label="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 style="text-align: center;"><span class="glyphicon glyphicon-lock"></span> Login</h4>
                    </div>
                    <div class="modal-body">
                        <form role="form">
                            <div class="form-group">
                                <label for="login-email"><span class="glyphicon glyphicon-user"></span> Email</label>
                                <input type="text" class="form-control" id="login-email" name="email" placeholder="Enter email" value="">
                            </div>
                            <div class="form-group">
                                <label for="login-password"><span class="glyphicon glyphicon-eye-open"></span> Password</label>
                                <input type="text" class="form-control" name="password" id="login-password" placeholder="Enter password">
                            </div>
                            <div class="checkbox" id="remember-me">
                                <label for="remember-me-box">
                                    <input id="remember-me-box" type="checkbox" value="" checked>Remember me</label>
                            </div>
                            <button type="submit" class="btn btn-default btn-success btn-block"><span class="glyphicon glyphicon-off"></span> Login</button>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <p>Not a member? <a data-toggle="modal" href="#signup-modal" data-dismiss="modal">Sign Up</a></p>
                        <p>Forgot <a id="forgot-password" href="{{ url('/password/email') }}">Password?</a></p>
                    </div>
                </div>
            </div>
        </div>

        <style>
            .modal-body {
                max-height: calc(100vh - 210px);
                overflow-y: auto;
            }
        </style>

        <div class="modal fade signup-modal" id="signup-modal" tabindex="-1" role="dialog"
             aria-labelledby="SignUp">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close close-modal-btn" data-dismiss="modal"
                                aria-label="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 style="text-align: center;"><span class="glyphicon glyphicon-lock"></span> Sign Up</h4>
                    </div>
                    <div class="modal-body">
                        <form role="form">
                            <div class="form-group">
                                <label class="sr-only" for="register-first">First Name</label>
                                <input type="text" class="form-control" id="register-first" placeholder="First name">
                            </div>
                            <div class="form-group">
                                <label class="sr-only" for="register-last">Last Name</label>
                                <input type="text" class="form-control" id="register-last" placeholder="Last name">
                            </div>
                            <div class="form-group">
                                <label class="sr-only" for="register-email">Email</label>
                                <input type="email" class="form-control" id="register-email" placeholder="Email">
                            </div>
                            <div class="form-group">
                                <label class="sr-only" for="register-password">Password</label>
                                <input type="text" class="form-control" id="psw" placeholder="Password">
                            </div>
                            <div class="form-group">
                                <label class="sr-only" for="register-phone">Phone Number</label>
                                <input type="tel" class="form-control phone_number" name="phone_number" id="register-phone"
                                       placeholder="Phone number" value="">
                            </div>
                            <div class="form-group">
                                <select class="form-control" name="university_id">
                                    <label class="sr-only" for="register-uni">School</label>
                                    <option id="register-uni" selected disabled>University</option>
                                    {{--@foreach($universities as $university)
                                        <option value="{{ $university->id }}">{{ $university->name }}</option>
                                    @endforeach--}}
                                </select>
                            </div>
                            <button type="submit" class="btn btn-default btn-success btn-block"><span class="glyphicon glyphicon-off"></span> Sign Up</button>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <p>Already a member? <a data-toggle="modal" href="#login-modal" data-dismiss="modal">Login</a></p>
                        <p>Forgot <a id="forgot-password" href="{{ url('/password/email') }}">Password?</a></p>
                    </div>
                </div>
            </div>
        </div>


    </div>




@endsection

@section('javascript')
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
@endsection