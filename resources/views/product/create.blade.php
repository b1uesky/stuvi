{{--/textbook/sell/product/create/#--}}

@extends('app')

@section('title', 'Enter book info')

@section('css')
    <link href="{{ asset('/css/product_create.css') }}" rel="stylesheet">
    <link href="{{ asset('dropzone-4.0.1/dist/dropzone.css') }}" rel="stylesheet">
@endsection

@section('content')
    <!-- message -->
    <div class="container" id="message-cont" xmlns="http://www.w3.org/1999/html">
        @if (Session::has('message'))
            <div class="flash-message" id="message" >{{ Session::get('message') }}</div>
        @endif
    </div>

    <div class="container create-container">

        {{-- Errors for invalid data --}}
        @if ($errors->has())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    {{ $error }}<br>
                @endforeach
            </div>
        @endif

        <div class="row textbook-row col-sm-5">
            <div class="textbook-info">
                <h2>{{ $book->title }}</h2>

                <div class="img-container">
                    <img class="img-large" src="{{ $book->imageSet->large_image or config('book.default_image_path.large') }}"/>
                </div>

                <div class="authors-container">
                    <span>by </span>
                    @foreach($book->authors as $author)
                        <span id="authors"><button class="btn btn-default author-btn disabled">{{ $author->full_name }}</button></span>
                    @endforeach
                </div>
                <p>ISBN-10: {{ $book->isbn10 }}</p>
                <p>ISBN-13: {{ $book->isbn13 }}</p>
                <p>Number of Pages: {{ $book->num_pages }}</p>
            </div>
        </div>

        {{-- If the user is not logged in, show login / signup buttons. --}}
        @if(!Auth::check())
            <div class="row col-sm-6 col-sm-offset-1">
                <p>Please login or sign up to continue using our service.</p>
                <a data-toggle="modal" href="#login-modal">Login</a>
                <a data-toggle="modal" href="#signup-modal">Sign up</a>
            </div>
        @else
            {{-- Show book conditions --}}
            <div class="row col-sm-6 col-sm-offset-1">
            <h2>Book Conditions</h2>

            <form id="form-product" class="dropzone">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="book_id" value="{{ $book->id }}"/>
                <input type="hidden" name="book_title" value="{{ $book->title }}">

                {{-- General Condition --}}
                <div class="form-group">
                    <label>{{ Config::get('product.conditions.general_condition.title') }}</label>
                    <i class="fa fa-question-circle" data-toggle="modal" data-target=".condition-modal"></i>
                    <br>

                    <div class="modal fade condition-modal" tabindex="-1" role="dialog"
                         aria-labelledby="General Conditions">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close close-modal-btn" data-dismiss="modal"
                                            aria-label="close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <h3>{{ Config::get('product.conditions.general_condition.title') }}</h3>
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

                    <div class="btn-group" data-toggle="buttons">
                        <label class="btn btn-default condition-btn">
                            <input type="radio" name="general_condition"
                                   value="0"> {{ Config::get('product.conditions.general_condition')[0] }}
                        </label>
                        <label class="btn btn-default condition-btn">
                            <input type="radio" name="general_condition"
                                   value="1"> {{ Config::get('product.conditions.general_condition')[1] }}
                        </label>
                        <label class="btn btn-default condition-btn">
                            <input type="radio" name="general_condition"
                                   value="2"> {{ Config::get('product.conditions.general_condition')[2] }}
                        </label>
                        <label class="btn btn-default condition-btn">
                            <input type="radio" name="general_condition"
                                   value="3"> {{ Config::get('product.conditions.general_condition')[3] }}
                        </label>
                    </div>
                </div>

                {{-- Highlights/Notes --}}
                <div class="form-group">
                    <label>{{ Config::get('product.conditions.highlights_and_notes.title') }}</label>
                    <i class="fa fa-question-circle" data-toggle="modal" data-target=".highlight-modal"></i>
                    <br>

                    <div class="modal fade highlight-modal" tabindex="-1" role="dialog"
                         aria-labelledby="Highlights/Notes">
                        <div class="modal-dialog modal-md">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close close-modal-btn" data-dismiss="modal"
                                            aria-label="close">
                                        <span id="close-span" aria-hidden="true">&times;</span>
                                    </button>
                                    <h3>{{ Config::get('product.conditions.highlights_and_notes.title') }}</h3>
                                </div>
                                <div class="modal-body">
                                    <p>{{ Config::get('product.conditions.highlights_and_notes.description') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="btn-group" data-toggle="buttons">
                        <label class="btn btn-default condition-btn">
                            <input type="radio" name="highlights_and_notes"
                                   value="0"> {{ Config::get('product.conditions.highlights_and_notes')[0] }}
                        </label>
                        <label class="btn btn-default condition-btn">
                            <input type="radio" name="highlights_and_notes"
                                   value="1"> {{ Config::get('product.conditions.highlights_and_notes')[1] }}
                        </label>
                        <label class="btn btn-default condition-btn">
                            <input type="radio" name="highlights_and_notes"
                                   value="2"> {{ Config::get('product.conditions.highlights_and_notes')[2] }}
                        </label>
                    </div>
                </div>

                {{-- Damaged Pages --}}
                <div class="form-group">
                    <label>{{ Config::get('product.conditions.damaged_pages.title') }}</label>
                    <i class="fa fa-question-circle" data-toggle="modal" data-target=".damage-modal"></i>
                    <br>

                    <div class="modal fade damage-modal" tabindex="-1" role="dialog" aria-labelledby="Damaged Pages">
                        <div class="modal-dialog modal-md">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close close-modal-btn" data-dismiss="modal"
                                            aria-label="close">
                                        <span id="close-span" aria-hidden="true">&times;</span>
                                    </button>
                                    <h3>{{ Config::get('product.conditions.damaged_pages.title') }}</h3>
                                </div>
                                <div class="modal-body">
                                    <p>{{ Config::get('product.conditions.damaged_pages.description') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="btn-group" data-toggle="buttons">
                        <label class="btn btn-default condition-btn">
                            <input type="radio" name="damaged_pages"
                                   value="0"> {{ Config::get('product.conditions.damaged_pages')[0] }}
                        </label>
                        <label class="btn btn-default condition-btn">
                            <input type="radio" name="damaged_pages"
                                   value="1"> {{ Config::get('product.conditions.damaged_pages')[1] }}
                        </label>
                        <label class="btn btn-default condition-btn">
                            <input type="radio" name="damaged_pages"
                                   value="2"> {{ Config::get('product.conditions.damaged_pages')[2] }}
                        </label>
                    </div>
                </div>

                {{-- Broken Binding --}}
                <div class="form-group">
                    <label>{{ Config::get('product.conditions.broken_binding.title') }}</label>
                    <i class="fa fa-question-circle" data-toggle="modal" data-target=".binding-modal"></i>
                    <br>

                    <div class="modal fade binding-modal" tabindex="-1" role="dialog" aria-labelledby="Broken Binding">
                        <div class="modal-dialog modal-md">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close close-modal-btn" data-dismiss="modal"
                                            aria-label="close">
                                        <span id="close-span" aria-hidden="true">&times;</span>
                                    </button>
                                    <h3>{{ Config::get('product.conditions.broken_binding.title') }}</h3>
                                </div>
                                <div class="modal-body">
                                    <p>{{ Config::get('product.conditions.broken_binding.description') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="btn-group" data-toggle="buttons">
                        <label class="btn btn-default condition-btn">
                            <input type="radio" name="broken_binding"
                                   value="0"> {{ Config::get('product.conditions.broken_binding')[0] }}
                        </label>
                        <label class="btn btn-default condition-btn">
                            <input type="radio" name="broken_binding"
                                   value="1"> {{ Config::get('product.conditions.broken_binding')[1] }}
                        </label>
                    </div>
                </div>

                {{-- Description --}}
                <div class="form-group">
                    <label>{{ Config::get('product.conditions.description.title') }}</label>
                    <textarea name="description" class="form-control" rows="5"
                              placeholder="{{ Config::get('product.conditions.description.place_holder') }}"></textarea>
                </div>
                {{-- Price --}}

                {{-- list price --}}
                {{--@if($book->list_price)--}}
                    {{--<div>List price: ${{ $book->list_price }}</div>--}}
                {{--@endif--}}

                {{-- your price --}}
                <div class="form-group">
                    <label for="price-form">Price</label>

                    <div class="input-group" id="price-input">
                        <div class="input-group-addon">$</div>
                        <input type="number" step="0.01" name="price" class="form-control" id="price-form"
                               placeholder="Amount">
                    </div>
                </div>

                {{-- Upload Images using Dropzone --}}
                <div class="form-group">
                    <label>Upload Textbook Image</label>
                    <div id="dropzone-img-preview" class="dropzone-previews dz-clickable">
                        <div class="dz-message">
                            Drop images here or click to upload.
                            <br>
                            <small>(A front cover image is required. You can upload three images in maximum.)</small>
                        </div>
                    </div>
                </div>

                <button type="submit" name="submit" class="btn primary-btn sell-btn">Post Book</button>
            </form>
        </div>
        @endif
    </div>
@endsection

@section('javascript')
    <script src="{{ asset('dropzone-4.0.1/dist/dropzone.js') }}"></script>

    @if(Auth::check())
        {{-- FormValidation --}}
        {{--<script src="{{asset('formvalidation-dist-v0.6.3/dist/js/formValidation.min.js')}}"></script>--}}
        {{--<script src="{{asset('formvalidation-dist-v0.6.3/dist/js/framework/bootstrap.min.js')}}"></script>--}}

        {{--<script src="{{ asset('js/validator/product-create.js') }}"></script>--}}
        <script src="{{ asset('js/product/create.js') }}"></script>
    @endif
@endsection
