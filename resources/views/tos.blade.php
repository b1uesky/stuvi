

        <!-- extends the nav bar and the footer -->
@extends('layouts.textbook')

@section('title', 'Terms of Service')

        <!-- put your css link refs here -->
@section('css')
     <link type="text/css" href="{{ asset('css/tos-privacy.css') }}" rel="stylesheet">
@endsection

        <!-- all page content here. in-between nav and footer -->
@section('content')

    <div class="container">

        @include('includes.tos-content')

    </div>

@endsection

@section('javascript')

@endsection