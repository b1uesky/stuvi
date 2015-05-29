<!-- Prototype Homepage Copyright Stuvi 2015
     Made by Nick                            -->

@extends('app')    <!-- app.blade.php -->
<head>
    <link type="text/css" href="{{ asset('css/home.css') }}" rel="stylesheet" >               <!-- Home style sheet -->

    <!-- Content Info -->
    <title>Stuvi Home - Student Village - Textbooks, Housing, Clubs, & More </title>
    <meta name="description" content="Student Village, college service provider">
    <meta name="author" content="Stuvi">
</head>

@section('content')

    <div class = "container-fluid container-top backgnd">           <!-- Top half -->
        <div class="container col-md-12">                               <!-- container -->
            <div class = "col-md-2"></div>                                  <!-- Buffer -->
            <div class="jumbotron col-md-8" id = "jumbotron1">              <!-- Jumbotron1 -->
                <h1 id = "head1" >Get ready for Stuvi's Launch Party!</h1>
                <p id = "p1">
                    Stuvi is designed to provide convenient, and valuable services to maximize a college student’s campus
                    life experience. In order to ensure our users a streamlined, and self-sufficient college life,
                    we're dedicated to create a "Student Village" where we can learn, share and grow. Whether you're
                    new to the area, or a die-hard local, you're going to need info such as: course information, professor
                    ratings, discount textbooks, and living spaces. Our goal is to provide you, the student, with all the
                    tools you need to conquer college.
                    <br/><br/>
                    We are a group of college students currently based in Boston, MA and hope to use our experience
                    to help you succeed at school.
                    <b><i> Welcome to Stuvi. Welcome home.</i></b>
                </p> <!-- end p1 -->

                <p id = "liftoff"> Liftoff on: August 2015</p>

            </div> <!-- end jumbotron1 -->
        </div>    <!-- end container -->
    </div>    <!-- end contain-top backgnd -->

    <!-- End Top Half
         Begin Bottom Half-->

    <div class = "container-fluid" id = "bottom-half">   <!-- Bottom Half -->
        <div class = "container">                           <!-- container -->
            <h2 id= "head2"> Our Services </h2>

            <!-- Divider Line -->
            <div class = "row">
                <div class = "span12" id = "hr-style-one">
                    <hr>
                </div>
            </div>
            <!-- end divider -->
            <!-- Columns stack when xs -->
            <div class = "container" id = "servicesTable">                         <!-- begin table -->
                <!-- row 1 -->
                <div class = "row">
                    <!-- row 1 column 1 -->
                    <div class = "col-xs-12 col-xs-offset-3 col-sm-4 col-sm-offset-1 col-md-4 col-md-offset-1 col-buff" >                                       <!-- r1c1 -->
                        <img src = "http://placehold.it/350x350" class="img-responsive">
                    </div>  <!-- end r1c1-->

                    <div class = "col-xs-12 col-xs-offset-3 col-sm-4 col-sm-offset-1 col-md-4 col-md-offset-2 col-buff">                      <!-- r1c2 -->
                        <img src = "http://placehold.it/350x350" class="img-responsive">
                    </div>  <!-- end r1c2 -->
                </div>  <!-- end row1 -->

                <!-- row 2 -->
                <div class = "row">
                    <div class = "col-xs-12 col-xs-offset-3 col-sm-4 col-sm-offset-1 col-md-4 col-md-offset-1 col-buff" >                                       <!-- r1c1 -->
                        <img src = "http://placehold.it/350x350" class="img-responsive">
                    </div>  <!-- end r2c1-->

                    <div class = "col-xs-12 col-xs-offset-3 col-sm-4 col-sm-offset-1 col-md-4 col-md-offset-2 col-buff">                      <!-- r1c2 -->
                        <img src = "http://placehold.it/350x350" class="img-responsive">
                    </div>  <!-- end r2c2 -->
                </div>  <!-- end row2 -->
            </div>   <!-- end container for table -->
        </div>    <!-- end container for hr and table -->
    </div>   <!-- end container bottom-half -->



@endsection
