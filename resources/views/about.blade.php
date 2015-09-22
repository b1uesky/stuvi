@extends('layouts.textbook')

@section('title', 'About us')

@section('css')
    <link rel="stylesheet" href="{{ asset('libs/ihover/src/ihover.min.css') }}">
@endsection

@section('content')

    <div class="container">
        <div class="page-header">
            <h1>About Stuvi</h1>
        </div>

        <p>
            We are a team of Computer Science students at Boston University. We created Stuvi (Student Village) as a student solution service,
            ranging from textbook deliveries, to managing academic life. To kick-off our launch, we're offering a new method to buy and sell
            your textbooks. Simply search for your book, describe its condition, and start making money.
        </p>

        {{--<br>--}}

            {{--<div class="row">--}}

                {{--<div class="col-sm-3">--}}
                    {{--<div class="ih-item circle colored effect13 from_left_and_right team-member"><a href="#">--}}
                            {{--<div class="img"><img src="{{ asset('/img/team/tianyou.png') }}" alt="img"></div>--}}
                            {{--<div class="info">--}}
                                {{--<div class="info-back">--}}
                                    {{--<h3>Tianyou Luo</h3>--}}
                                    {{--<p>Back End Developer</p>--}}
                                {{--</div>--}}
                            {{--</div></a>--}}
                    {{--</div>--}}
                {{--</div>--}}

                {{--<div class="col-sm-3">--}}
                    {{--<div class="ih-item circle colored effect13 from_left_and_right team-member"><a href="#">--}}
                            {{--<div class="img"><img src="{{ asset('/img/team/Pengcheng-Ding.jpg') }}" alt="img"></div>--}}
                            {{--<div class="info">--}}
                                {{--<div class="info-back">--}}
                                    {{--<h3>Desmond Ding</h3>--}}
                                    {{--<p>Full Stack Developer</p>--}}
                                {{--</div>--}}
                            {{--</div></a>--}}
                    {{--</div>--}}
                {{--</div>--}}

                {{--<div class="col-sm-3">--}}
                    {{--<div class="ih-item circle colored effect13 from_left_and_right team-member"><a target="_blank" href="https://www.linkedin.com/in/patelsanam">--}}
                            {{--<div class="img"><img src="{{ asset('/img/team/sanam.jpg') }}" alt="img"></div>--}}
                            {{--<div class="info">--}}
                                {{--<div class="info-back">--}}
                                    {{--<h3>Sanam Patel</h3>--}}
                                    {{--<p>Front End Developer</p>--}}
                                {{--</div>--}}
                            {{--</div></a>--}}
                    {{--</div>--}}
                {{--</div>--}}

                {{--<div class="col-sm-3">--}}
                    {{--<div class="ih-item circle colored effect13 from_left_and_right team-member"><a target="_blank" href="https://www.linkedin.com/in/louienick">--}}
                            {{--<div class="img"><img src="{{ asset('/img/team/Nick.jpg') }}" alt="img"></div>--}}
                            {{--<div class="info">--}}
                                {{--<div class="info-back">--}}
                                    {{--<h3>Nick Louie</h3>--}}
                                    {{--<p>Front End Developer</p>--}}
                                {{--</div>--}}
                            {{--</div></a>--}}
                    {{--</div>--}}
                {{--</div>--}}

            {{--</div>--}}
        </div>

@endsection