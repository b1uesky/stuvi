{{--textbook/buy/product/#--}}

@extends('product')

@section('content')
<head>
    <title>Stuvi - Book Details - {{ $book->title }} </title>
    <link rel="stylesheet" href="{{asset('/css/product/product-show.css')}}" type="text/css">
</head>

@include('textbook/textbook-nav')

<div class="container-fluid" id="bg">
    <div class="row back-row">
        <a id="go-back" href="" onclick="goBack()" ><i class="fa fa-arrow-circle-left"></i> Back to {{ $book->title }}</a>
    </div>

    <div class="container" id="det-cont">
        <div class="row">
            <div class="col-sm-6 col-md-4">

                <!-- images use lightbox -->
                {{-- Only shows first image as large, the rest will be below it as smaller images--}}
                @if(!empty($images))
                    <?php $x = 0; ?>
                    @foreach($images as $image)
                        <?php $x++ ?>
                        @if($x == 1)
                            <a class="lightbox-product-link" href="{{ $image->path }}"
                               data-lightbox="pro-img" data-title="Image {{$image->id}}">
                                <img class="pro-img" src="{{ $image->path }}" alt="Book Image" />
                            </a>
                            <br>
                        @else
                            <a class="lightbox-product-link" href="{{ $image->path }}"
                               data-lightbox="pro-img" data-title="Image {{$image->id}}">
                                <img class="pro-img-small" src="{{ $image->path }}" alt="Book Image" />
                            </a>
                        @endif
                    @endforeach
                @endif

                <h2>{{ $book->title }}</h2>

                <div class="price">
                    Price: <b>${{ $product->price }}</b>
                </div>

                <a class="btn add-cart-btn" href="{{ url('/cart/add/'.$product->id) }}">Add to Cart</a>

            </div>

            <table class="table table-responsive details-table col-xs-12 col-sm-6 col-md-6">
                <tr>
                    <th>Condition</th>
                    <th>Description</th>
                </tr>
                <tr>
                    <td>{{ $conditions['general_condition']['title'] }}</td>
                    <td>{{ $conditions['general_condition'][$condition->general_condition] }}</td>
                </tr>
                <tr>
                    <td>{{ $conditions['highlights_and_notes']['title'] }}</td>
                    <td>{{ $conditions['highlights_and_notes'][$condition->highlights_and_notes] }}</td>
                </tr>
                <tr>
                    <td>{{ $conditions['damaged_pages']['title'] }}</td>
                    <td>{{ $conditions['damaged_pages'][$condition->damaged_pages] }}</td>
                </tr>
                <tr>
                    <td>{{ $conditions['broken_binding']['title'] }}</td>
                    <td>{{ $conditions['broken_binding'][$condition->broken_binding] }}</td>
                </tr>
            </table>
            <div class="container col-md-4 seller-desc">
                @if($condition->description != '')
                    <h4>Seller's description on the book conditions:</h4>
                    <div class="">
                        {{ $condition->description }}
                    </div>
                @endif
            </div>

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

    <!-- lightbox required -->
    {{--http://lokeshdhakar.com/projects/lightbox2/--}}
    <script src="{{asset('/js/jquery.min.js')}}"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
    <script src="{{asset('lightbox2-master/dist/js/lightbox.min.js')}}"></script>
    <link href="{{asset('lightbox2-master/dist/css/lightbox.css')}}" rel="stylesheet">
@endsection
