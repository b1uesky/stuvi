

        <!-- extends the nav bar and the footer -->
@extends('layouts.textbook')

@section('title', 'Terms of Service')



        <!-- all page content here. in-between nav and footer -->
@section('content')

    <div class="container">

        @include('includes.tos-content')

    </div>

@endsection

@section('javascript')

@endsection