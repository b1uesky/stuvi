{{--User Profile page--}}


@extends('app')
@section('title', 'Profile - '.Auth::user()->first_name.' '.Auth::user()->last_name )

@section('css')
    <link href="{{ asset('/css/user_profile.css') }}" rel="stylesheet">
@endsection

@section('content')
    <!-- User template has the second nav bar and the profile side bar -->
    @include('user-template')
            <div class="col-md-9">
                <div class="profile-content">
                    <!-- right box -->
                    <div class="container col-xs-12 col-md-12" id = "profile-details">
                        <!-- User Stats -->
                        <h2 id = "details"><i class="fa fa-bar-chart"></i>
                            User Stats</h2>
                                <div class="table-responsive">
                                    <table class="table table-condensed">
                                        <!-- joined -->
                                        <tr id ="details-joined">
                                            <td><i class="fa fa-user-plus"></i>
                                                <b> Joined: </b></td>
                                            <td>{{ date("m/d/Y", strtotime(Auth::user()->created_at)) }}</td>
                                            <td></td>
                                        </tr>
                                        {{--<!-- rep -->--}}
                                        {{--<tr id ="details-rep">--}}
                                            {{--<td><i class="fa fa-thumbs-o-up"></i>--}}
                                                {{--<b> Reputation: </b></td>--}}
                                            {{--<td>9001</td>--}}
                                            {{--<td></td>--}}
                                        {{--</tr>--}}
                                        <!-- books sold -->
                                        <tr id="details-books-sold">
                                            <td><i class="fa fa-share"></i>
                                                    <b> Books Sold: </b></td>
                                            <td>{{ $num_books_sold }}</td>
                                            <td></td>
                                        </tr>
                                        <!-- books purchased -->
                                        <tr id="details-books-purchased">
                                            <td><i class="fa fa-reply"></i>
                                                <b> Books Purchased: </b></td>
                                            <td>{{ $num_books_bought }}</td>
                                            <td></td>
                                        </tr>
                                    </table>
                                </div>  <!-- end user stats -->
                            </div>
                            <!-- books selling -->

                        </div>
            <!-- needed to end user bar -->
                     </div>
                </div>
            </div>
        </div>
    </div>

@endsection

<!-- inserted at the end of app -->
@section('javascript')
    <!-- Slick required -->
    {{--
        <script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
        <script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
        <script type="text/javascript" src="{{asset('/slick/slick.min.js')}}"></script>

    --}}
    <script type="text/javascript" src="{{asset('js/user/profile.js')}}"></script>
@endsection
