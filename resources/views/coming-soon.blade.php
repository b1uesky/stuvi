@extends('layouts.textbook')

@section('title', 'Coming Soon!')

@section('css')
    <link rel="stylesheet" href="{{asset('css/comingSoon.css')}}" type="text/css">
@endsection

@section('content')

    <div class="container-fluid background">
        <div class="jumbotron">
            <h1 class="row">Coming Soon!</h1>
            <p class="row">We're working to create more features.</br>
                <small>Sign up for our newsletter to be regularly updated on new services.</small>
            </p>

            <div class="container">
                <form class="form-inline" >
                    <div class="form-group col-md-5">
                        <label class="sr-only" for="newsletter">Email address</label>
                        <input type="email" class="form-control" id="exampleInputEmail3" placeholder="Email">
                        <button type="submit" class="btn btn-news">Sign up</button>
                    </div>
                </form>
                <p class="col-md-1 or" style="">or</p>
                <a href="" onclick="goBack()" class="btn btn-news col-sm-7 col-md-5 col-md-offset-1"><i class="fa fa-arrow-left"></i> Go Back</a>
            </div>
        </div>
    </div>


@endsection

@section('javascript')

    <script>
        function goBack() {
            window.history.back();
        }
    </script>
@endsection

