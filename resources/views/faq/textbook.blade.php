@extends('app')

@section('title', 'FAQ')

@section('css')
    <link href="{{ asset('/css/faq.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container faq-container">
        @include('faq/side-nav')
        <div class="col-sm-7 col-sm-offset-1 qa-container">
            <h2>FAQ - Textbook</h2>
            <hr class="faq-line">
            <div class="question-answer">
                <h3>Will the textbooks be in good condition?</h3>

                <p>
                    Stuvi guarantees that every book's condition matches the seller's description.
                </p>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
@endsection