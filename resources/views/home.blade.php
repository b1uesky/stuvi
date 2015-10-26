@extends('layouts.textbook')
@section('description', "Student Village, college service provider")
@section('title', 'Boston Textbook Marketplace & More Coming Soon!')

@section('textbook-header')
    <div id="navbar-transparent">
        @include('includes.textbook.header')
    </div>
@overwrite

@section('content')

    <div class="container-fluid container-bg">

        <div class="container-top-half">

            <div class="va-container va-container-h va-container-v">
                <div class="va-middle text-center">
                    <h1 class="header-text">Welcome to Stuvi</h1>
                    <p class="lead tagline">Because it takes a village to conquer college.</p>
                </div>
            </div>

            <div class="container-search">
                @include('includes.textbook.buy-searchbar')
            </div>
        </div>
    </div>

    <section class="intro bg-white">
        <!-- Intro -->
        <div class="jumbotron">
            <div class="container text-center">
                <h1>What is Stuvi?</h1>
                <p>Stuvi is a marketplace built for college students, by college students. We're here to provide relevant services to help you succeed at school, and we're launching here in Boston, Massachusetts!</p>
                <p><a class="btn btn-primary btn-lg" href="{{ url('/about/') }}" role="button">Learn more</a></p>
            </div>
        </div>
    </section>

@endsection
