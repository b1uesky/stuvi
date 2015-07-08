{{--textbook/buy/product/#--}}

<!-- TODO: There is an issue with javascript not working when the screensize is sm -->

@extends('app')

@section('title', 'Book Details')

@section('css')
    <link rel="stylesheet" href="{{asset('/css/product/product-show.css')}}" type="text/css">
@endsection

@section('content')
<head>
    <title>Stuvi - Book Details - {{ $book->title }} </title>
</head>

@include('textbook/textbook-nav')

<div class="container-fluid" id="bg">
    <!-- book details -->
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
                            <label>{{ $conditions['general_condition']['title'] }}</label>
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

                                            <p>
                                                A new, unread, unused book in perfect condition with no missing or damaged
                                                pages.
                                            </p>
                                            <h4>Excellent</h4>

                                            <p>
                                                No missing or damaged pages, no creases or tears,and no underlining/highlighting
                                                of text or writing in the margins. Very minimal wear and tear.
                                            </p>
                                            <h4>Good</h4>

                                            <p>
                                                Very minimal damage to the cover, but no holes or tears.
                                                The majority of pages are undamaged with minimal creasing
                                                or tearing. Minimal underlining or highlighting. No missing pages.
                                            </p>
                                            <h4>Acceptable</h4>

                                            <p>
                                                A book with obvious wear. The binding may be slightly damaged but not broken.
                                                Possible writing in margins, possible underlining and highlighting of text,
                                                but no missing pages or anything that would compromise the legibility or
                                                understanding of the text.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>{{ $conditions['general_condition'][$condition->general_condition] }}</td>
                </tr>
                <!-- Highlights / Notes -->
                <tr>
                    <td>
                        <div class="form-group">
                            <label>{{ $conditions['highlights_and_notes']['title'] }}</label>
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
                                            <p>
                                                Please select the approximate number of pages that contain
                                                highlighted/underlined material or notes.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>{{ $conditions['highlights_and_notes'][$condition->highlights_and_notes] }}</td>
                </tr>
                <!-- Damaged Pages -->
                <tr>
                    <td>
                        <div class="form-group">
                            <label>{{ $conditions['damaged_pages']['title'] }}</label>
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
                                            <p>
                                                Please select the approximate number of damaged pages.
                                                This includes folded or partially torn pages and water damage.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>{{ $conditions['damaged_pages'][$condition->damaged_pages] }}</td>
                </tr>
                <!-- Broken Binding -->
                <tr>
                    <td>
                        <div class="form-group">
                            <label>{{ $conditions['broken_binding']['title'] }}</label>
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
                                            <p>
                                                Please select "yes" if the binding is severely damaged
                                                or completely broken. Please note that the buyer will be
                                                warned about this book's poor condition and will likely not
                                                be willing to pay full price for this book.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>{{ $conditions['broken_binding'][$condition->broken_binding] }}</td>
                </tr>
            </table>
            <!-- Seller Description -->
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
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>

    <!-- lightbox required -->
    {{--http://lokeshdhakar.com/projects/lightbox2/--}}
    <script src="{{asset('lightbox2-master/dist/js/lightbox.min.js')}}"></script>
    <link href="{{asset('lightbox2-master/dist/css/lightbox.css')}}" rel="stylesheet">
@endsection
