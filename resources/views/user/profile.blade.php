@extends('app')
@section('title', 'Profile')

@section('content')
    <head>

        <title> Stuvi - {{ Auth::user()->first_name }} {{ Auth::user()->last_name }} - Profile </title>
        <link href="{{ asset('/css/profile.css') }}" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="{{asset('/slick/slick.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('/slick/slick-theme.css')}}">
    </head>

    @include('user-template')
    <div class="col-md-9">
        <div class="profile-content">
            <!-- User Stats -->
            <div class="container col-xs-9 col-md-8" id = "profile-details">
                <h2 id = "details"><i class="fa fa-bar-chart"></i>
                    User Stats</h2>

                        <div class="table-responsive">
                            <table class="table table-condensed">
                                <tr id ="details-joined">
                                    <td><i class="fa fa-users"></i>
                                        <b> Joined: </b></td>
                                    <td>08/01/15</td>
                                    <td></td>
                                </tr>
                                <tr id ="details-rep">
                                    <td><i class="fa fa-thumbs-o-up"></i>
                                        <b> Reputation: </b></td>
                                    <td>9001</td>
                                    <td></td>
                                </tr>

                                <tr id="details-books-sold">
                                    <td><i class="fa fa-share"></i>
                                            <b> Books Sold: </b></td>
                                    <td>69</td>
                                    <td></td>
                                </tr>
                                <tr id="details-books-purchased">
                                    <td><i class="fa fa-reply"></i>
                                        <b> Books Purchased: </b></td>
                                    <td>0</td>
                                    <td></td>
                                </tr>
                            </table>
                        </div>


                    </div>



                    <div class="container col-xs-11 col-md-12" id = "books-for-sale">
                        <h2 id = "for-sale"><i class="fa fa-book"></i>
                            Books for Sale</h2>
                        <hr class="hr">

                        <div class="container col-md-11 col-md-offset-1 slider responsive books">
                            <div><img src="http://placehold.it/100x150"></div>
                            <div><img src="http://placehold.it/100x150"></div>
                            <div><img src="http://placehold.it/100x150"></div>
                            <div><img src="http://placehold.it/100x150"></div>
                            <div><img src="http://placehold.it/100x150"></div>
                        </div>


                    </div>
                </div>

    <!-- needed to end user bar -->
    </div>
    </div>
    </div>
    </div>
    </div>


    <!-- Slick required -->
    <script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <script type="text/javascript" src="{{asset('/slick/slick.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/profile.js')}}"></script>

@endsection


@endsection