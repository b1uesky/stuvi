{{-- Use this as a template for a completely new page.--}}

<!-- extends the nav bar and the footer -->
@extends('app')

@section('title', 'Title here')

<!-- put your css link refs here -->
@section('css')

@endsection

<!-- all page content here. in-between nav and footer -->
@section('content')

    <div class="container-fluid background">
        <div class="container-fluid">

        </div>
    </div>

@endsection

<!-- all javascript is loaded after the footer -->
@section('javascript')
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
@endsection