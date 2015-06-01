@extends('app')

@section('content')
    {{-- image link -> http://commons.wikimedia.org/wiki/File:Stuvi.JPG--}}

    <head>
        <link href="{{ asset('/css/about.css') }}" rel="stylesheet">
        <link href="{{ asset('/css/ihover.css') }}" rel="stylesheet">
        <title>About Us</title>
    </head>

    <div class="container-fluid about-background">
        <img src="{{asset('/img/stuvi.jpeg')}}">
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-8 col-xs-offset-2 col-sm-6 col-sm-offset-3 about-stuvi">
                <h2>About Stuvi</h2>
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla ultrices sodales urna, quis faucibus elit
                    tempor vitae. Suspendisse suscipit arcu at mattis volutpat. Proin eu ipsum ut sapien fermentum tristique.
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla ultrices sodales urna, quis faucibus elit
                    tempor vitae. Suspendisse suscipit arcu at mattis volutpat. Proin eu ipsum ut sapien fermentum tristique.
                </p>
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
        <div class="row team-grid">
            <div class="col-sm-6 col-md-4">
                <div class="ih-item circle colored effect13 from_left_and_right"><a href="#">
                        <div class="img"><img src="{{ asset('/img/temp.jpg') }}" alt="img"></div>
                        <div class="info">
                            <div class="info-back">
                                <h3>Heading here</h3>
                                <p>Description goes here</p>
                            </div>
                        </div></a>
                </div>
            </div>
            <div class="col-sm-6 col-md-4">
                <div class="ih-item circle colored effect13 from_left_and_right"><a href="#">
                        <div class="img"><img src="{{ asset('/img/temp.jpg') }}" alt="img"></div>
                        <div class="info">
                            <div class="info-back">
                                <h3>Heading here</h3>
                                <p>Description goes here</p>
                            </div>
                        </div></a>
                </div>
            </div>
        </div>
    </div>




@endsection