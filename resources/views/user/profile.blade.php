{{--User Profile page--}}


@extends('app')
@section('title', 'Profile')

@section('content')
    <head>
        <title> Stuvi - {{ Auth::user()->first_name }} {{ Auth::user()->last_name }} - Profile </title>
        <link href="{{ asset('/css/profile.css') }}" rel="stylesheet">
   {{--     <link rel="stylesheet" type="text/css" href="{{asset('/slick/slick.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('/slick/slick-theme.css')}}">--}}
    </head>
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
                                        <!-- rep -->
                                        <tr id ="details-rep">
                                            <td><i class="fa fa-thumbs-o-up"></i>
                                                <b> Reputation: </b></td>
                                            <td>9001</td>
                                            <td></td>
                                        </tr>
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
                            <div class="container col-xs-12 col-md-12" id = "books-for-sale">
                                <a href="{{url('user/bookshelf')}}"><h2 id = "for-sale"><i class="fa fa-book"></i>
                                    Books for Sale</h2></a>
                                {{-- <hr class="hr">
                             <div class="container col-md-11 col-md-offset-1 slider responsive books">
                                     <div><img src="http://placehold.it/100x150"></div>
                                     <div><img src="http://placehold.it/100x150"></div>
                                     <div><img src="http://placehold.it/100x150"></div>
                                     <div><img src="http://placehold.it/100x150"></div>
                                     <div><img src="http://placehold.it/100x150"></div>
                                 </div>--}}
                                <table class="table table-responsive for-sale-table">
                                    @forelse ($productsForSale as $key => $product)
                                        @if ($key < 2)
                                            <tr class="for-sale-item">
                                                <td class="for-sale-img">
                                                    <img class="img-responsive"
                                                         src="{{ url($product->images()->first()->path) }}"
                                                         width="100px"
                                                         height="150px"></td>
                                                <td class="for-sale-info-1">
                            <span class="for-sale-title"><a
                                        href="{{ url('textbook/buy/product/'.$product->id) }}">{{ $product->book->title }}</a></span><br>
                                                    <span>by </span>
                                                    @foreach($product->book->authors as $author)
                                                        <span class="for-sale-author"><a
                                                                    href="#">{{ $author->full_name }}</a></span>
                                                    @endforeach

                                                    <span class="for-sale-binding">Hardcover</span><br>
                                                    <span class="for-sale-price">{{ $product->price }}</span> <br>
                                                </td>
                                                <td class="for-sale-info-2">
                                                    <span class="for-sale-isbn">ISBN-10: {{ $product->book->isbn10 }}</span>
                                                    <span class="for-sale-isbn">ISBN-13: {{ $product->book->isbn13 }}</span>
                                                </td>

                                                <td class="for-sale-info-3">
                                                    <!-- each class the book support -->
                                                    <h5>Classes</h5>
                                                    <span class="for-sale-class"><a href="#">BU:SMG SM131</a></span>
                                                </td>
                                            </tr>
                                        @endif
                                    @empty
                                        You don't have book for sale.
                                    @endforelse
                                </table>
                            </div>
                        </div>
            <!-- needed to end user bar -->
                     </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Slick required -->
    <script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script> <!-- .active required -->
{{--
    <script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <script type="text/javascript" src="{{asset('/slick/slick.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/profile.js')}}"></script>
--}}

@endsection


