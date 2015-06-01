@extends('app')

@section('content')
    {{-- image link -> http://commons.wikimedia.org/wiki/File:Stuvi.JPG--}}

    <head>
        <link href="{{ asset('/css/about.css') }}" rel="stylesheet">
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
    </div>




@endsection