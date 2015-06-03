@extends('app')

@section('content')
    <head>
        <link href="{{ asset('/css/contact.css') }}" rel="stylesheet">
        <title>Contact Us</title>
    </head>

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
                        {{--<label>Message</label>--}}
                        <textarea class="form-control" rows="5" placeholder="Message"></textarea>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn contact-button">Submit</button>
                    </div>
                </form>
            </div>

            <div class="col-sm-5 social-container">
                <h4>Connect with us on social media!</h4>
                <div class="social-links">
                    <a href="#">
                        <img src="{{ asset('/img/facebook.png') }}">
                    </a>
                    <a href="#">
                        <img src="{{ asset('/img/twitter.png') }}">
                    </a>
                    <a href="#">
                        <img src="{{ asset('/img/github.png') }}">
                    </a>
                </div>
            </div>
        </div>
        <!-- boston.jpg licensing -->
        <p id="license" style="text-align: right;"><small>Background Photo by
                <a href="https://flic.kr/p/rZ8kmG" target = "_blank"> John Collins </a>
                under <a href="https://creativecommons.org/licenses/by/2.0/" target = "_blank"> CC-BY-2.0</a>
                </small>
        </p>
    </div>


@endsection