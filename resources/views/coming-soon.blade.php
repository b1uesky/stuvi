@extends('app')

@section('title', 'Coming Soon!')

@section('css')
    <style>
        .background{
            background-image: url('{{asset('img/coming.jpg')}}');
            background-size: cover;
            min-height: 70vh;
        }
        .jumbotron {
            margin: 10% 10%;
            background-color: rgba(153, 159, 163, 0.45);
        }

        h1{
            margin-left: -5px;
        }
    </style>
@endsection

@section('content')

    <div class="container-fluid background">
        <div class="jumbotron">
            <h1 style="">Coming Soon!</h1>
            <p>Hold the fuck on.</p>
            <a href="" onclick="goBack()" class="btn btn-warning"><i class="fa fa-arrow-left"></i> back dat ass up</a>
        </div>
    </div>

@endsection

@section('javascript')
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>

    <script>
        function goBack() {
            window.history.back();
        }
    </script>
@endsection

