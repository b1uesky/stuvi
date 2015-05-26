<!-- Prototype Homepage Copyright Stuvi 2015 -->

@extends('app')
<head>
    <link href="{{ asset('/css/login.css') }}" rel="stylesheet">
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="{{asset('js/bootstrap.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('/js/login.js')}}" type="text/javascript"></script>

    <link type="text/css" href="{{asset('css/home.css')}}" rel="stylesheet" >
    <link rel="stylesheet" href="{{asset('css/font-awesome.min.css')}}">
    <title>Stuvi Index</title>
</head>

@section('content')

    <div class = "container-fluid container-top backgnd">

        <div class="container col-md-12">
            <div class = "col-md-2"></div>
            <div class="jumbotron col-md-8">
                <h1 id = "head1" >Get ready for Stuvi's Launch Party!</h1>

                <!-- Temp cover image...(c)Nicholas Louie All Rights Reserved. I Nicholas Louie, hereby allow a limited license
                 to display this image on Stuvi's website with proper name and link credit. This photo may not be distributed, used
                 or changed in any other way other than on the homepage -->
                <img src="{{asset('/img/cover.jpg')}}" class = "img-responsive"
                     alt="Photo by Nick Louie Link: https://flic.kr/p/kSKWtK">

                <p id = "p1">
                    Stuvi is designed to provide convenient, and valuable services to maximize a college student’s campus life experience.
                    In order to ensure our users, a happy, simple, and great college life, we're dedicated to create
                    a "Student Village" where we can learn, share and grow. Whether you're new to the area, or a die-hard local, you'll need
                    info such as: course information, professor ratings, discount textbooks, and living
                    spaces. Our goal is to provide you, the student, with all the things you need to conquer college.
                    <br/><br/>
                    We are a group of college students based in Boston, MA and hope to use our experience to help you succeed.
                </p>

                <!-- The container is used to define the width of the slideshow -->

                <!-- Slider currently not working.. 5/25/15 4PM.. but we might not have wanted to keep it anyways  -->
                <div class="container">

                    <div id="slides">
                        <img src="{{asset('img/example-slide-1.jpg')}}" alt="Photo by: Missy S Link: http://www.flickr.com/photos/listenmissy/5087404401/">
                        <img src="{{asset('img/example-slide-2.jpg')}}" alt="Photo by: Daniel Parks Link: http://www.flickr.com/photos/parksdh/5227623068/">
                        <img src="{{asset('img/example-slide-3.jpg')}}" alt="Photo by: Mike Ranweiler Link: http://www.flickr.com/photos/27874907@N04/4833059991/">
                        <img src="{{asset('img/example-slide-4.jpg')}}" alt="Photo by: Stuart SeegerLink: http://www.flickr.com/photos/stuseeger/97577796/">
                        <a href="#" class="slidesjs-previous slidesjs-navigation"><i class="icon-chevron-left icon-large"></i></a>
                        <a href="#" class="slidesjs-next slidesjs-navigation"><i class="icon-chevron-right icon-large"></i></a>
                    </div>
                </div>
                <!-- End SlidesJS Required: Start Slides -->


            </div>
        </div>
    </div>

    <!-- End top half -->

    <div class = "container-fluid" id = "bottom-half">

        <div class = "container">

            <h2 id= "head2"> Our Services </h2> <!-- Fix color -->

            <!-- Divider Line -->
            <div class = "row">
                <div class = "span12" id = "hr-style-one">
                    <hr>
                </div>
            </div>


            <!-- Fix alignment for sm and md.. -->
            <div class = "container" style = "text-align:center;">
                <div class = "row">
                    <div class = "col-md-5 col-buff">
                        <img src = "http://placehold.it/500x300" class="img-responsive">
                    </div>

                    <div class = " col-sm-offset-1 col-md-5 col-buff">
                        <img src = "http://placehold.it/500x300" class="img-responsive">
                    </div>
                </div>


                <div class = "row grid-buff">
                    <div class = "col-md-5 col-buff">
                        <img src = "http://placehold.it/500x300" class="img-responsive">
                    </div>

                    <div class = " col-sm-offset-1 col-md-5 col-buff">
                        <img src = "http://placehold.it/500x300" class="img-responsive">
                    </div>
                </div>

            </div>
        </div>


    </div>

    <!-- SlidesJS Required: Link to jQuery
    <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
     End SlidesJS Required -->

    <!-- SlidesJS Required: Link to jquery.slides.js -->
    <script src="{{asset('js/jquery.slides.min.js')}}"></script>
    <!-- End SlidesJS Required -->


    <!-- SlidesJS Required: Initialize SlidesJS with a jQuery doc ready -->
    <script>
        $(function() {
            $('#slides').slidesjs({
                width: 940,
                height: 528,
                navigation: false
            });
        });
    </script>



@endsection
