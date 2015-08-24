<!-- Copyright Stuvi LLC 2015 -->

@extends('layouts.home')
@section('description', "Student Village, college service provider")
@section('title', 'Boston Textbook Marketplace & More Coming Soon!')

@section('css')
    <link type="text/css" href="{{ asset('css/home.css') }}" rel="stylesheet">
@endsection

@section('content')

    <div class="container-header">
        @include('includes.textbook.header')
    </div>

    <div class="container-fluid container-bg">

        <div class="container-content">

            <div class="va-container va-container-h va-container-v">
                <div class="va-middle text-center">
                    <h1 class="header-text">Welcome to Stuvi</h1>
                    <p class="lead tagline">Because it takes a village to conquer college.</p>
                </div>
            </div>

            <div class="container-search">
                <div class="searchbar default-searchbar">
                    <label class="sr-only" for="autocomplete">Textbook Search</label>

                    <form action="/textbook/buy/search" method="get">
                        <div class="searchbar-input-container searchbar-input-container-query">
                            <input type="text" name="query" id="autocomplete"
                                   class="form-control searchbar-input searchbar-input-query"
                                   placeholder="Enter the textbook ISBN, Title, or Author"/>
                        </div>

                        {{--Show school selection if it's a guest--}}
                        @if(Auth::guest())
                            <div class="searchbar-input-container searchbar-input-container-university">
                                <label class="sr-only" for="uni_id">University</label>
                                <select name="university_id" class="form-control searchbar-input searchbar-input-university"
                                        id="uni_id">
                                    <option value="" selected disabled>Select a university</option>
                                    @foreach(\App\University::where('is_public', true)->get() as $university)
                                        <option value="{{ $university->id }}">{{ $university->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif

                        <div class="searchbar-input-container searchbar-input-container-submit default-guest-search-submit">
                            <input class="btn primary-btn search-btn" type="submit" value="Search">
                        </div>
                    </form>
                </div>

                <div class="xs-guest-search-bar">
                    <form action="/textbook/buy/search" method="get">
                        <label class="sr-only" for="autocompleteBuy">Textbook Search</label>
                        <div class="xs-guest-search-bar-input">
                            <input type="text" name="query" id="autocompleteBuy"
                                   class="form-control searchbar-input searchbar-input-query"
                                   placeholder="Enter the textbook ISBN, Title, or Author"/>
                        </div>
                        {{--Show school selection if it's a guest--}}
                        @if(Auth::guest())
                            <div class="xs-guest-search-bar-input-uni">
                                <label class="sr-only" for="xs-uni_id">University ID</label>
                                <select name="university_id" class="form-control searchbar-input" id="xs-uni-id">
                                    <option value="" selected disabled>Select a university</option>
                                    @foreach(\App\University::where('is_public', true)->get() as $university)
                                        <option value="{{ $university->id }}">{{ $university->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                        <div class="xs-guest-search-bar-input-submit">
                            <button class="btn primary-btn btn-lg" type="submit" value="Search" style="width:100%;">
                                Search
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <section class="intro bg-white">
        <!-- Intro -->
        <div class="jumbotron">
            <div class="container text-center">
                <h1>What is Stuvi?</h1>
                <p>Stuvi is a marketplace built for college students, by college students. We're here to provide relevant services to help you succeed at school, and we're launching here in Boston, Massachusetts!</p>
                <p><a class="btn primary-btn btn-lg" href="{{ url('/about/') }}" role="button">Learn more</a></p>
            </div>
        </div>
    </section>

@endsection

@section('javascript')
    <script src="libs/jquery-ui/jquery-ui.min.js"></script>
    <script src="{{asset('js/autocomplete.js')}}"></script>
@endsection
