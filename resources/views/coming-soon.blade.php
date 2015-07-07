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

        .btn-news{
            background: #F16521;
            color: #FFFFFF;
            border: none;
        }
    </style>
@endsection

@section('content')

    <div class="container-fluid background">
        <div class="jumbotron">
            <h1 style="">Coming Soon!</h1>
            <p>Hold the fuck on.</p>
            <small class="col-sm-offset-1">Sign up for our newsletter if you actually care.</small>
            <div class="row">
                <form class="form-inline col-sm-4 col-sm-offset-1">
                    <div class="form-group">
                        <label class="sr-only" for="newsletter">Email address</label>
                        <input type="email" class="form-control" id="exampleInputEmail3" placeholder="Email">
                        <button type="submit" class="btn btn-news">Sign up</button>
                    </div>
                </form>
                <p class="col-sm-1" style="font-size: large;">or</p>
                <a href="" onclick="goBack()" class="btn btn-news col-sm-5"><i class="fa fa-arrow-left"></i> back dat ass up</a>
            </div>
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

