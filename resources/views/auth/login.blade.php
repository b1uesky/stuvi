@extends('login-register')

@section('title', 'Login & Register')

@section('css')
    <link href="{{ asset('/css/auth_login.css') }}" rel="stylesheet">
    <link href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.5/css/bootstrap-select.min.css" rel="stylesheet">
@endsection

{{--set starting tab based on clicked nav button--}}
{{--the code below is not commented, it's blade syntax for variables--}}
@if (isset($loginType) && $loginType == 'login')
    {{--*/ $loginActive = ' active' /*--}}
    {{--*/ $signupActive = '' /*--}}
@else
    {{--*/ $loginActive = '' /*--}}
    {{--*/ $signupActive = ' active' /*--}}
@endif

@section('content')
    <div class="container-fluid content">
        <!-- logo -->
        <a href="{{ url('/') }}" id="logo-link"><img src="{{asset('/img/logo-new-center.png')}}" class="img-responsive"
                                                     id="login-logo"></a>

        <div class="row vertical-center">
            <div class="col-sm-6 col-sm-offset-3">
                <div class="container" id="form-container">
                    <!-- tabs -->
                    <ul class="nav nav-tabs nav-justified" role="tablist" id="tabs">
                        <!-- login tab-->
                        <li role="presentation" class="{{ $loginActive }}" id="login-tab"><a href="#login-body"
                                                                                             aria-controls="login-body"
                                                                                             role="tab"
                                                                                             data-toggle="tab">Login</a>
                        </li>
                        <!-- signup tab-->
                        <li role="presentation" class="{{ $signupActive }}" id="signup-tab"><a href="#signup-body"
                                                                                               aria-controls="signup-body"
                                                                                               role="tab"
                                                                                               data-toggle="tab">Sign Up</a>
                        </li>
                    </ul>
                    <!-- end tabs -->

                    {{-- Messages --}}
                    @if (Session::has('message'))
                        <div class="alert alert-danger">
                            <ul>
                                <li>{{ Session::get('message') }}</li>
                            </ul>
                        </div>
                    @endif

                    {{-- Errors for invalid data --}}
                    @if ($errors->has())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Successfully scheduled a pickup time --}}
                    @if(Session::has('success'))
                        <div class="alert alert-success">{{ Session::get('success') }}</div>
                    @endif
                    <div class="tab-content">
                        <!-- login -->
                        <div class="tab-pane {{ $loginActive }}" id="login-body">
                            <form class="form-horizontal login-form" role="form" method="POST"
                                  action="{{ url('/auth/login') }}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <!-- email -->
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-8 form-space-offset">
                                        <label class="sr-only" for="login-email">Email address</label>
                                        <input type="email" class="form-control input" name="email" id="login-email" placeholder="Email"
                                               value="{{ old('email') }}">
                                    </div>
                                </div>
                                <!-- password -->
                                <div id="password-group" class="form-group">
                                    <label class="sr-only" for="login-password">Password</label>
                                    <div class="col-sm-offset-2 col-sm-8">
                                        <input type="password" class="form-control" name="password" id="login-password"
                                               placeholder="Password">
                                    </div>
                                </div>
                                <!-- remember -->
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-8">
                                        <div class="checkbox" id="remember-me">
                                            <label for="remember-me-box">
                                                <input type="checkbox" name="remember" id="remember-me-box"> Remember Me
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <!-- forgot pw -->
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-8">
                                        <button type="submit" class="btn primary-btn submit-btn">Login</button>
                                        <br>
                                        <a class="btn btn-link" id="forgot-password"
                                           href="{{ url('/password/email') }}">
                                            Forgot Your Password?
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- sign up -->
                        <div class="tab-pane {{ $signupActive }}" id="signup-body">
                            <form class="form-horizontal" role="form" method="POST" action="{{ url('/auth/register') }}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <!-- first name -->
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-8 form-space-offset">
                                        <label class="sr-only" for="register-first">First name</label>
                                        <input type="text" class="form-control" name="first_name" id="register-first"
                                               placeholder="First Name" value="{{ old('first_name') }}">
                                    </div>
                                </div>
                                <!-- last name -->
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-8">
                                        <label class="sr-only" for="register-last">Last name</label>
                                        <input type="text" class="form-control" name="last_name" id="register-last"
                                               placeholder="Last Name" value="{{ old('last_name') }}">
                                    </div>
                                </div>
                                <!-- email -->
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-8">
                                        <label class="sr-only" for="register-email">Email address</label>
                                        <input type="email" class="form-control" name="email" id="register-email"
                                               placeholder="Email" value="{{ old('email') }}">
                                    </div>
                                </div>
                                <!-- password -->
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-8">
                                        <label class="sr-only" for="register-password">Password</label>
                                        <input type="password" class="form-control" name="password" id="register-password"
                                               placeholder="Password">
                                    </div>
                                </div>
                                <!-- phone number -->
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-8">
                                        <label class="sr-only" for="register-phone">Phone Number</label>
                                        <input type="tel" class="form-control phone_number" name="phone_number" id="register-phone"
                                               placeholder="Phone Number" value="{{ old('phone_number') }}">
                                    </div>
                                </div>
                                <!-- school -->
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-8">
                                        <select class="form-control" name="university_id">
                                            <label class="sr-only" for="register-uni">School</label>
                                            <option id="register-uni" selected disabled>University</option>
                                            @foreach($universities as $university)
                                                <option value="{{ $university->id }}">{{ $university->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <!-- tos statement-->
                                <div class="tos col-sm-offset-2 col-sm-8">
                                    By creating an account, you agree to Stuvi's <a href="#" data-toggle="modal"
                                                                                    data-target=".terms-modal">Terms of
                                        Use</a> and
                                    <a href="#" data-toggle="modal" data-target=".privacy-modal">Privacy Notice</a>.
                                </div>
                                <!-- sign up button-->
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-8">
                                        <button type="submit" class="btn primary-btn submit-btn">Sign Up</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- terms of use -->
        <div class="modal fade terms-modal" tabindex="-1" role="dialog" aria-labelledby="Terms of Use">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close close-modal-btn" data-dismiss="modal"
                                aria-label="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h3>Terms of Use</h3>
                    </div>
                    <div class="modal-body">
                        <p>
                            Welcome to Stuvi. If you continue to browse and use this website, you are agreeing to comply with and be bound by the following terms and conditions of use, which together with our privacy policy govern Stuvi’s relationship with you in relation to this website. If you disagree with any part of these terms and conditions, please do not use our website.
                            The term ‘Stuvi’ or ‘us’ or ‘we’ refers to the owner of the website whose registered office is [address]. Our company registration number is [company registration number and place of registration]. The term ‘you’ refers to the user or viewer of our website.
                            The use of this website is subject to the following terms of use: </br>
                            The content of the pages of this website is for your general information and use only. It is subject to change without notice.
                            This website uses cookies to monitor browsing preferences. If you do allow cookies to be used, the following personal information may be stored by us for use by third parties.
                        </p>
                            <ul>
                                <li>Neither we nor any third parties provide any warranty or guarantee as to the accuracy, timeliness, performance, completeness or suitability of the information and materials found or offered on this website for any particular purpose. You acknowledge that such information and materials may contain inaccuracies or errors and we expressly exclude liability for any such inaccuracies or errors to the fullest extent permitted by law.</li>
                                <li>Your use of any information or materials on this website is entirely at your own risk, for which we shall not be liable. It shall be your own responsibility to ensure that any products, services or information available through this website meet your specific requirements.</li>
                                <li>This website contains material which is owned by or licensed to us. This material includes, but is not limited to, the design, layout, look, appearance and graphics. Reproduction is prohibited other than in accordance with the copyright notice, which forms part of these terms and conditions.</li>
                                <li>All trademarks reproduced in this website, which are not the property of, or licensed to the operator, are acknowledged on the website.</li>
                                <li>Unauthorised use of this website may give rise to a claim for damages and/or be a criminal offence.</li>
                                <li>From time to time, this website may also include links to other websites. These links are provided for your convenience to provide further information. They do not signify that we endorse the website(s). We have no responsibility for the content of the linked website(s).</li>
                                <li>Your use of this website and any dispute arising out of such use of the website is subject to the laws of The United States of America.</li>
                            </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- privacy notice -->
        <div class="modal fade privacy-modal" tabindex="-1" role="dialog" aria-labelledby="Privacy Notice">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close close-modal-btn" data-dismiss="modal"
                                aria-label="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h3>Privacy Notice</h3>
                    </div>
                    <div class="modal-body">
                        <p>
                            This privacy policy discloses the privacy practices for Stuvi.com. This privacy policy applies solely to information collected by this web site. It will notify you of the following:
                        </p>
                            <ol>
                                <li>What personally identifiable information is collected from you through the web site, how it is used and with whom it may be shared.</li>
                                <li>What choices are available to you regarding the use of your data.</li>
                                <li>The security procedures in place to protect the misuse of your information.</li>
                                <li>How you can correct any inaccuracies in the information.</li>
                            </ol>

                            <h3>Information Collection, Use, and Sharing</h3>
                            <p>We are the sole owners of the information collected on this site. We only have access to/collect information that you voluntarily give us via email or other direct contact from you. We will not sell or rent this information to anyone.</p>

                            <p>We will use your information to respond to you, regarding the reason you contacted us. We will not share your information with any third party outside of our organization, other than as necessary to fulfill your request, e.g. to ship an order.</p>

                            <p>Unless you ask us not to, we may contact you via email in the future to tell you about specials, new products or services, or changes to this privacy policy.</p>

                            <h3>Your Access to and Control Over Information</h3>
                            <p>You may opt out of any future contacts from us at any time. You can do the following at any time by contacting us via the email address or phone number given on our website:</p>
                            <ul>
                                <li>See what data we have about you, if any.</li>
                                <li>Change/correct any data we have about you.</li>
                                <li>Have us delete any data we have about you.</li>
                                <li>Express any concern you have about our use of your data.</li>
                            </ul>
                        
                            <h3>Security</h3>
                            <p>We take precautions to protect your information. When you submit sensitive information via the website, your information is protected both online and offline.</p>

                            <p>Wherever we collect sensitive information (such as credit card data), that information is encrypted and transmitted to us in a secure way. You can verify this by looking for a closed lock icon at the bottom of your web browser, or looking for "https" at the beginning of the address of the web page.</p>

                            <p>While we use encryption to protect sensitive information transmitted online, we also protect your information offline. Only employees who need the information to perform a specific job (for example, billing or customer service) are granted access to personally identifiable information. The computers/servers in which we store personally identifiable information are kept in a secure environment.</p>

                            <h3>Updates</h3>

                            <p>Our Privacy Policy may change from time to time and all updates will be posted on this page.</p>

                            <p><strong>If you feel that we are not abiding by this privacy policy, you should contact us immediately at <a href="mailto:official@stuvi.com">official@stuvi.com</a>.</strong></p>

                            <h3>Orders</h3>
                            <p>We request information from you on our order form. To buy from us, you must provide contact information (like name and shipping address) and financial information (like credit card number, expiration date). This information is used for billing purposes and to fill your orders. If we have trouble processing an order, we'll use this information to contact you.</p>

                            <h3>Links</h3>
                            <p>This web site contains links to other sites. Please be aware that we are not responsible for the content or privacy practices of such other sites. We encourage our users to be aware when they leave our site and to read the privacy statements of any other site that collects personally identifiable information.</p>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('javascript')
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.5/js/bootstrap-select.min.js"></script>
@endsection

