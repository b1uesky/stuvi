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

                <p>
                    Farm-to-table roof party High Life, VHS actually 8-bit artisan freegan food truck vegan fixie art
                    party ethical drinking vinegar. Pork belly fap Truffaut 3 wolf moon, Pinterest irony cliche umami.
                    McSweeney's Pinterest tote bag, Echo Park VHS fanny pack gastropub High Life literally drinking vinegar
                    authentic art party Vice. PBR viral Kickstarter, small batch Tumblr normcore High Life kale chips mumblecore
                    flannel Echo Park Pitchfork Truffaut fap. Cardigan fingerstache forage, hoodie PBR&B B#anksy lumbersexual
                    cray literally McSweeney's Helvetica Wes Anderson. Keffiyeh post-ironic artisan disrupt literally High Life,
                    YOLO try-hard bicycle rights forage. DIY Blue Bottle master cleanse craft beer, four dollar toast semiotics
                    90's occupy next level.
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

    <div class = "container-fluid">

        <div class = "container">

            <h2 id= "head2"> Our Services </h2> <!-- Fix color -->
            <hr>

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
    <script src="js/jquery.slides.min.js"></script>
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
