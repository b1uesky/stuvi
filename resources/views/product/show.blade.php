{{--textbook/buy/product/#--}}


@extends('app')

<title>Stuvi - Book Details - {{ $product->book->title }} </title>

@section('css')
    <link rel="stylesheet" href="{{asset('/css/product/product-show.css')}}" type="text/css">
@endsection

@section('content')

@include('textbook/textbook-nav')

<div class="container-fluid" id="bg">
    <!-- book details -->
    <div class="container" id="det-cont">
        <div class="row">
            <div class="col-sm-6 col-md-4">
                <!-- images use lightbox -->
                {{-- Only shows first image as large, the rest will be below it as smaller images--}}
                @if($product->images)
                    @foreach($product->images as $index => $image)
                        @if($index == 0)
                            <a class="lightbox-product-link" href="{{ Config::get('aws.url.stuvi-product-img') . $image->large_image }}"
                               data-lightbox="pro-img" data-title="Image {{$image->id}}">
                                <img class="pro-img" src="{{ Config::get('aws.url.stuvi-product-img') . $image->medium_image }}" alt="Book Image" />
                            </a>
                            <br>
                        @else
                            <a class="lightbox-product-link" href="{{ Config::get('aws.url.stuvi-product-img') . $image->large_image }}"
                               data-lightbox="pro-img" data-title="Image {{$image->id}}">
                                <img class="pro-img-small" src="{{ Config::get('aws.url.stuvi-product-img') . $image->small_image }}" alt="Book Image" />
                            </a>
                        @endif
                    @endforeach
                @endif
                <h2>{{ $product->book->title }}</h2>
                <div class="price">
                    Price: <b>${{ $product->price }}</b>
                </div>
                <a class="btn add-cart-btn" href="{{ url('/cart/add/'.$product->id) }}">Add to Cart</a>
            </div>

            <!-- Condition -->
            <table class="table table-responsive details-table col-xs-12 col-sm-6 col-md-6">
                <tr>
                    <th>Condition</th>
                    <th>Description</th>
                </tr>
                <!-- General Condition -->
                <tr>
                    <td>
                        <div class="form-group">
                            <label>{{ Config::get('product.conditions.general_condition.title') }}</label>
                            <i class="fa fa-question-circle" data-toggle="modal" data-target=".condition-modal"></i>
                            <div class="modal fade condition-modal" tabindex="-1" role="dialog"
                                 aria-labelledby="General Conditions">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close close-modal-btn" data-dismiss="modal"
                                                    aria-label="close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            <h3>General Conditions</h3>
                                        </div>
                                        <div class="modal-body">
                                            <h4>Brand New</h4>
                                            <p>{{ Config::get('product.conditions.general_condition.description')[0] }}</p>

                                            <h4>Excellent</h4>
                                            <p>{{ Config::get('product.conditions.general_condition.description')[1] }}</p>

                                            <h4>Good</h4>
                                            <p>{{ Config::get('product.conditions.general_condition.description')[2] }}</p>

                                            <h4>Acceptable</h4>
                                            <p>{{ Config::get('product.conditions.general_condition.description')[3] }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>{{ Config::get('product.conditions.general_condition')[$product->condition->general_condition] }}</td>
                </tr>
                <!-- Highlights / Notes -->
                <tr>
                    <td>
                        <div class="form-group">
                            <label>{{ Config::get('product.conditions.highlights_and_notes.title') }}</label>
                            <i class="fa fa-question-circle" data-toggle="modal" data-target=".highlight-modal"></i>
                            <div class="modal fade highlight-modal" tabindex="-1" role="dialog"
                                 aria-labelledby="Highlights/Notes">
                                <div class="modal-dialog modal-md">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close close-modal-btn" data-dismiss="modal"
                                                    aria-label="close">
                                                <span id="close-span" aria-hidden="true">&times;</span>
                                            </button>
                                            <h3>Highlights/Notes</h3>
                                        </div>
                                        <div class="modal-body">
                                            <p>{{ Config::get('product.conditions.highlights_and_notes.description') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>{{ Config::get('product.conditions.highlights_and_notes')[$product->condition->highlights_and_notes] }}</td>
                </tr>
                <!-- Damaged Pages -->
                <tr>
                    <td>
                        <div class="form-group">
                            <label>{{ Config::get('product.conditions.damaged_pages.title') }}</label>
                            <i class="fa fa-question-circle" data-toggle="modal" data-target=".damage-modal"></i>
                            <div class="modal fade damage-modal" tabindex="-1" role="dialog" aria-labelledby="Damaged Pages">
                                <div class="modal-dialog modal-md">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close close-modal-btn" data-dismiss="modal"
                                                    aria-label="close">
                                                <span id="close-span" aria-hidden="true">&times;</span>
                                            </button>
                                            <h3>Damaged Pages</h3>
                                        </div>
                                        <div class="modal-body">
                                            <p>{{ Config::get('product.conditions.damaged_pages.description') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>{{ Config::get('product.conditions.damaged_pages')[$product->condition->damaged_pages] }}</td>
                </tr>
                <!-- Broken Binding -->
                <tr>
                    <td>
                        <div class="form-group">
                            <label>{{ Config::get('product.conditions.broken_binding.title') }}</label>
                            <i class="fa fa-question-circle" data-toggle="modal" data-target=".binding-modal"></i>
                            <div class="modal fade binding-modal" tabindex="-1" role="dialog" aria-labelledby="Broken Binding">
                                <div class="modal-dialog modal-md">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close close-modal-btn" data-dismiss="modal"
                                                    aria-label="close">
                                                <span id="close-span" aria-hidden="true">&times;</span>
                                            </button>
                                            <h3>Broken Binding</h3>
                                        </div>
                                        <div class="modal-body">
                                            <p>{{ Config::get('product.conditions.broken_binding.description') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>{{ Config::get('product.conditions.broken_binding')[$product->condition->broken_binding] }}</td>
                </tr>
            </table>

            <!-- Seller Description -->
            <div class=" col-xs-12 col-sm-12 col-md-4 seller-desc">
                @if($product->condition->description != '')
                    <h4>Seller's description on the book conditions:</h4>
                    <div>{{ $product->condition->description }}</div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection

@section('javascript')
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>

    <!-- lightbox required -->
    {{--http://lokeshdhakar.com/projects/lightbox2/--}}
    <script src="{{asset('lightbox2-master/dist/js/lightbox.min.js')}}"></script>
    <link href="{{asset('lightbox2-master/dist/css/lightbox.css')}}" rel="stylesheet">
@endsection
