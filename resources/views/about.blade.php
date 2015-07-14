@extends('app')

@section('title', 'About us')

@section('css')
    <link href="{{ asset('/css_new/about.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/ihover.css') }}" rel="stylesheet">
@endsection

@section('content')

    <div class="container-fluid about-background">
        <div class="container col-md-12">                               <!-- container -->
            <div class = "col-md-2"></div>                                  <!-- Buffer -->
            <div class="jumbotron col-md-8" id = "about-jumbotron">              <!-- Jumbotron1 -->
                <h1 id = "about-title" >Welcome to our Village</h1>
            </div> <!-- end jumbotron1 -->
        </div>    <!-- end container -->
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-8 col-xs-offset-2 col-sm-6 col-sm-offset-3 about-stuvi">
                <h2>About Stuvi</h2>
                <p>
                   We're a team of Computer Science students at Boston University. We've created Stuvi (Student Village) as a student solution service,
                    ranging from textbook deliveries, to managing academic life. To kick-off our launch, we're offering a new method to buy and sell
                    your textbooks. Simply search for your book, describe its condition, and start making money.
        </div>
        </div>
        <div class="row">
            <div class="col-xs-8 col-xs-offset-2 col-sm-6 col-sm-offset-3 team">
                <h2>Our Team</h2>
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla ultrices sodales urna, quis faucibus elit
                    tempor vitae. Suspendisse suscipit arcu at mattis volutpat. Proin eu ipsum ut sapien fermentum tristique.
                </p>
            </div>
        </div>
        <div class="container team-container">
            <div class="row team-grid">
                <div class="col-sm-6 col-md-4">
                    <div class="ih-item circle colored effect13 from_left_and_right team-member"><a href="#">
                            <div class="img"><img src="{{ asset('/img/team/tianyou.png') }}" alt="img"></div>
                            <div class="info">
                                <div class="info-back">
                                    <h3>Tianyou Luo</h3>
                                    <p>NoScoper</p>
                                </div>
                            </div></a>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class="ih-item circle colored effect13 from_left_and_right team-member"><a target="_blank" href="https://www.linkedin.com/in/patelsanam">
                        <div class="img"><img src="{{ asset('/img/team/sanam.jpg') }}" alt="img"></div>
                        <div class="info">
                            <div class="info-back">
                                <h3>Sanam Patel</h3>
                                <p>Front End Developer</p>
                            </div>
                        </div></a>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class="ih-item circle colored effect13 from_left_and_right team-member"><a target="_blank" href="https://www.linkedin.com/in/louienick">
                        <div class="img"><img src="{{ asset('/img/team/Nick.jpg') }}" alt="img"></div>
                        <div class="info">
                            <div class="info-back">
                                <h3>Nick Louie</h3>
                                <p>Front End Developer</p>
                            </div>
                        </div></a>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class="ih-item circle colored effect13 from_left_and_right team-member"><a href="#">
                        <div class="img"><img src="{{ asset('/img/team/Pengcheng-Ding.jpg') }}" alt="img"></div>
                        <div class="info">
                            <div class="info-back">
                                <h3>Desmond Ding</h3>
                                <p>Back End Developer</p>
                            </div>
                        </div></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid google-map-container">
        <div class="overlay" onclick="style.pointerEvents='none'"></div>
        <iframe class="google-map" width="100%" height="400" frameborder="0" style="border:0"
                src="https://www.google.com/maps/embed/v1/place?q=Boston%20University%2C%20Boston%2C%20MA%2C%20United%20States&key=AIzaSyDPkT04jkZa3K8UO1K6cVQ1df0GjbA8LG4"></iframe>
    </div>


@endsection

@section('javascript')
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
@endsection