{{-- Use this as a template for a completely new page.--}}

<!-- extends the nav bar and the footer -->
@extends('app')

@section('title', 'Title here')

<!-- put your css link refs here -->
@section('css')

@endsection

<!-- all page content here. in-between nav and footer -->
@section('content')
    @include('includes.textbook.flash-message')

    <div class="container-fluid background container-main-content">
        <div class="container-fluid">

        </div>
    </div>

@endsection

<!-- all javascript is loaded after the footer -->
@section('javascript')
@endsection