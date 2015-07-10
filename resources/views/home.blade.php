<!-- Prototype Homepage Copyright Stuvi 2015 -->

@extends('app')    <!-- app.blade.php -->

@section('title', 'Textbooks, Housing, Clubs, & More')

@section('css')
    <link type="text/css" href="{{ asset('css/home.css') }}" rel="stylesheet">
@endsection

@section('content')

<!-- top jumbotron -->

    {{--
    * Temp cover image...(c)Nicholas Louie All Rights Reserved. I Nicholas Louie, hereby allow a limited license
    * to display this image on Stuvi's website with proper name and link credit. This photo may not be distributed, used
    * or altered (except sizing/cropping) in any other way other than on the homepage
    * Photo by Nick Louie. Link: https://flic.kr/p/kSKWtK
    --}}

    <div class = "container-fluid container-top backgnd">           <!-- Top half -->
        <div class="container top-content col-md-12">
            <h1 id="head1-temp">Welcome to Stuvi</h1>
            <p class="lead tagline">Because it takes a village to conquer college.</p>
            <!-- ghost buttons -->
            @if (Auth::guest())
                <div class="ghost-btn-container">
                    <a class="btn ghost-btn" href="{{ url('/auth/login') }}" role="button">LOGIN</a>
                    <a class="btn ghost-btn" href="{{ url('/auth/register') }}" role="button">SIGN UP</a>
                </div>
            @endif
        </div>

    </div> <!-- end contain-top backgnd -->
  <!-- new bottom half -->
    <div class="container-fluid" id="bottom-half">
        <div class="container-fluid stuvi-container">
            <!-- row 1-->
            <div class="row">
                <div class="container col-md-4 col-md-offset-2" id="info1">
                    <h1>What is Stuvi?</h1>

                    <p>
                        Stuvi is a marketplace built for college students, by college students. We're here to provide
                        relevant services to help you succeed at school, and we're launching here in Boston, Massachusetts!
                    </p>
                </div>
                <div class="container col-xs-offset-1 col-sm-7 col-sm-offset-3 col-md-offset-0 col-md-4" id="img-info-1">
                    {{--<img src="http://placehold.it/350x350">--}}
                    <img class="img-responsive" src="{{asset('/img/scaled/art-boston.jpg')}}" width="350px">
                </div>
            </div>

            <!-- TODO: Add more content -->

        </div>
        <!-- services-->
        <div class="container-fluid services">
            <div class="row">
                <h1>Our Services</h1>
            </div>
            <div class="row service-row">
                <div class="col-xs-12 col-sm-6 col-lg-3 service">
                    <a href="{{ url('/textbook') }}"><i class="fa fa-book fa-5x"></i></a>
                    <h4>Textbooks</h4>

                    <p>Buy and sell textbooks at your campus</p>
                </div>
                <div class="col-xs-12 col-sm-6 col-lg-3 service">
                    <a href="{{ url('/coming') }}"><i class="fa fa-home fa-5x"></i></a>
                    <h4>Housing</h4>

                    <p>Find off campus housing near your campus</p>
                </div>
                <div class="col-xs-12 col-sm-6 col-lg-3 service">
                    <a href="{{ url('/coming') }}"><i class="fa fa-university fa-5x"></i></a>
                    <h4>Clubs</h4>

                    <p>Get involved with clubs and organizations</p>
                </div>
                <div class="col-xs-12 col-sm-6 col-lg-3 service">
                    <a href="{{ url('/coming') }}"><i class="fa fa-users fa-5x"></i></a>
                    <h4>Groups</h4>

                    <p>Connect with students in your classes</p>
                </div>
            </div>
        </div> <!-- end services -->

    </div> <!-- end bottom half -->

@endsection

@section('javascript')
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
@endsection
