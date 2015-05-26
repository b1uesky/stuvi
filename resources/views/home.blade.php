<!-- Prototype Homepage Copyright Stuvi 2015 -->

@extends('app')
<head>
    <link href="{{ asset('/css/login.css') }}" rel="stylesheet">
    <script src="{{url('cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js')}}"></script>
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
            <div class="jumbotron col-md-8" id = "jumbotron1">
                <h1 id = "head1" >Get ready for Stuvi's Launch Party!</h1>

                <!-- Temp cover image...(c)Nicholas Louie All Rights Reserved. I Nicholas Louie, hereby allow a limited license
                 to display this image on Stuvi's website with proper name and link credit. This photo may not be distributed, used
                 or changed in any other way other than on the homepage -->
                <!-- <img src="{{asset('/img/cover.jpg')}}" class = "img-responsive"
                     alt="Photo by Nick Louie Link: https://flic.kr/p/kSKWtK"> -->

                <p id = "p1">
                    Stuvi is designed to provide convenient, and valuable services to maximize a college student’s campus
                    life experience.In order to ensure our users a streamlined, and self-sufficient college life,
                    we're dedicated to create a "Student Village" where we can learn, share and grow. Whether you're
                    new to the area, or a die-hard local, you'll need info such as: course information, professor
                    ratings, discount textbooks, and living spaces. Our goal is to provide you, the student, with all the
                    tools you need to conquer college.
                    <br/><br/>
                    We are a group of college students based in Boston, MA and hope to use our experience to help you succeed.
                    Welcome to Stuvi. Welcome home.
                </p>


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


@endsection
