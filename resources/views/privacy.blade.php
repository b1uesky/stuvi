{{-- Privacy Policy Page --}}

        <!-- extends the nav bar and the footer -->
@extends('layouts.textbook')

@section('title', 'Privacy Policy')

        <!-- put your css link refs here -->
@section('css')
     <link type="text/css" href="{{ asset('css/tos-privacy.css') }}" rel="stylesheet">
@endsection

        <!-- all page content here. in-between nav and footer -->
@section('content')

    <div class="container">

        @include('includes.privacy-content')

    </div>

    @endsection

<!-- all javascript is loaded after the footer -->
@section('javascript')

@endsection