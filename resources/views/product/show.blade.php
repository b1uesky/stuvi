{{--textbook/buy/product/#--}}


@extends('app')

<title>Stuvi - Book Details - {{ $product->book->title }} </title>

@section('css')
    <link rel="stylesheet" href="{{asset('/css/product_show.css')}}" type="text/css">
    <link rel="stylesheet" href="{{ asset('libs/lightbox2/dist/css/lightbox.css') }}">
@endsection

@section('content')


<div class="container-fluid" id="bg">

    @include('includes.textbook.flash-message')

    <!-- book details -->
    <div class="container" id="det-cont">
        <div class="row">
            <div class="col-sm-6 col-md-4 product-info">
                <!-- images use lightbox -->
                {{-- Only shows first image as large, the rest will be below it as smaller images--}}
                @if($product->images)
                    @forelse($product->images as $index => $image)
                        @if($index == 0)
                            @if($image->isTestImage())
                                {{-- show absolute urls of test images--}}
                                <a class="lightbox-product-link" href="{{ $image->large_image }}"
                                   data-lightbox="pro-img" data-title="Image {{$image->id}}">
                                    <img class="pro-img" src="{{ $image->medium_image }}" alt="Book Image" />
                                </a>
                            @else
                                {{-- show amazon urls --}}
                                <a class="lightbox-product-link" href="{{ Config::get('aws.url.stuvi-product-img') . $image->large_image }}"
                                   data-lightbox="pro-img" data-title="Image {{$image->id}}">
                                    <img class="pro-img" src="{{ Config::get('aws.url.stuvi-product-img') . $image->medium_image }}" alt="Book Image" />
                                </a>
                            @endif
                            <br><br>
                        @else
                            @if($image->isTestImage())
                                <a class="lightbox-product-link" href="{{ $image->large_image }}"
                                   data-lightbox="pro-img" data-title="Image {{$image->id}}">
                                    <img class="pro-img-small" src="{{ $image->small_image }}" alt="Book Image" />
                                </a>
                            @else
                                <a class="lightbox-product-link" href="{{ Config::get('aws.url.stuvi-product-img') . $image->large_image }}"
                                   data-lightbox="pro-img" data-title="Image {{$image->id}}">
                                    <img class="pro-img-small" src="{{ Config::get('aws.url.stuvi-product-img') . $image->small_image }}" alt="Book Image" />
                                </a>
                            @endif
                        @endif
                    @empty
                        <a class="lightbox-product-link" href="{{ config('book.default_image_path.large') }}"
                           data-lightbox="pro-img" data-title="Default Image">
                            <img class="pro-img" src="{{ config('book.default_image_path.large') }}" alt="Book Image" />
                        </a>
                    @endforelse
                @endif
                <h2 class="product-title"><a
                            href="{{ url('textbook/buy/'.$product->book->id) }}">{{ $product->book->title }}</a></h2>

                <div class="authors-container">
                    <span>by </span>
                    <?php $bookCounter = 0; ?>
                    @foreach($product->book->authors as $author)
                        @if($bookCounter == 0)
                            <span id="authors">{{ $author->full_name }}</span>
                        @else
                            <span id="authors">, {{ $author->full_name }}</span>
                        @endif
                        <?php $bookCounter++ ?>
                    @endforeach
                </div>
                <p>ISBN10: {{ $product->book->isbn10 }}</p>

                <p>ISBN13: {{ $product->book->isbn13 }}</p>

                <p>Number of Pages: {{ $product->book->num_pages }}</p>
                <div class="price">
                    Price: <b>${{ $product->decimalPrice() }}</b>
                </div>
                @if(Auth::check())
                    @if($product->isInCart(Auth::user()->id))
                        <a class="btn primary-btn add-cart-btn disabled" href="#" role="button">Added To Cart</a>
                    @elseif(!$product->isSold() && $product->seller == Auth::user())
                        <a class="btn primary-btn add-cart-btn" href="{{ url('textbook/sell/product/' . $product->id . '/edit') }}" role="button">Edit</a>
                    @else
                        <form method="post" class="add-to-cart">
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input class="btn primary-btn add-cart-btn" type="submit" value="Add to cart">
                        </form>
                    @endif
                @else
                    <br>
                    <p class="warning bg-warning">Please <a data-toggle="modal" href="#login-modal">Login</a> or <a data-toggle="modal" href="#signup-modal">Sign up</a> to buy this textbook.</p>
                @endif
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
                                            <p>{{ Config::get('product.conditions.highlights_and_notes.description_show') }}</p>
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
                                            <p>{{ Config::get('product.conditions.damaged_pages.description_show') }}</p>
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
                                            <p>{{ Config::get('product.conditions.broken_binding.description_show') }}</p>
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
    <script src="{{ asset('libs/lightbox2/dist/js/lightbox.min.js') }}"></script>
    <script src="{{ asset('js/cart.js') }}"></script>
@endsection
