@extends('app')

@section('title', 'Contact us')

@section('css')
    <link href="{{ asset('/css_new/contact.css') }}" rel="stylesheet">
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
                        <button type="submit" class="btn contact-btn">Submit</button>
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
                        {{--<li><a href="#"><i class="fa fa-github fa-lg"></i> Github</a></li>--}}
                    </ul>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('javascript')
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
@endsection