@extends('app')

@section('title', 'About us')

@section('css')
    <link href="{{ asset('/css/about.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('libs/ihover/src/ihover.min.css') }}">
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

    <div class="container-fluid no-overflow">
        <div class="row">
            <div class="col-xs-8 col-xs-offset-2 col-sm-6 col-sm-offset-3 about-stuvi">
                <h2>About Stuvi</h2>
                <p>
                   We're a team of Computer Science students at Boston University. We've created Stuvi (Student Village) as a student solution service,
                    ranging from textbook deliveries, to managing academic life. To kick-off our launch, we're offering a new method to buy and sell
                    your textbooks. Simply search for your book, describe its condition, and start making money.
                </p>
                <p>Want to know more? <a href="{{url('/faq/general')}}">Check out our FAQ.</a></p>
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
@endsection

@section('javascript')
@endsection