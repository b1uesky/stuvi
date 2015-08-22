{{--/textbook/sell/product/edit/#--}}

@extends('app')

@section('title', 'Edit Product Info')

@section('css')
    <link rel="stylesheet" href="{{ asset('libs/dropzone/dist/min/dropzone.min.css') }}">
    <link href="{{ asset('/css/product_create.css') }}" rel="stylesheet">
@endsection

@section('content')
    @include('includes.textbook.flash-message')

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
                <h2>{{ $product->book->title }}</h2>

                <div class="img-container">
                    @if($product->book->imageSet->isManuallyCreated())
                        <img class="img-large" src="{{ config('aws.url.stuvi-book-img') . $product->book->imageSet->large_image }}">
                    @else
                        <img class="img-large" src="{{ $product->book->imageSet->large_image or config('book.default_image_path.large') }}"/>
                    @endif
                </div>

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

                <p>ISBN-10: {{ $product->book->isbn10 }}</p>

                <p>ISBN-13: {{ $product->book->isbn13 }}</p>

                <p>Number of Pages: {{ $product->book->num_pages }}</p>
            </div>
        </div>

        {{-- Show book conditions --}}
        <div class="row col-sm-6 col-sm-offset-1">
            <h2>Book Conditions</h2>

            <form id="form-product" class="dropzone" action="{{ url('/textbook/sell/product/update') }}" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="product_id" value="{{ $product->id }}"/>

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
                                    @for ($i = 0; $i < 4; $i++)
                                        <dl>
                                            <dt>{{ Config::get('product.conditions.general_condition')[$i] }}</dt>
                                            <dd>{{ Config::get('product.conditions.general_condition.description')[$i] }}</dd>
                                        </dl>
                                    @endfor
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="btn-group" data-toggle="buttons">
                        @for ($i = 0; $i < 4; $i++)
                            <label class="btn btn-default condition-btn
                                @if ($product->condition->general_condition == $i) active @endif">
                                <input type="radio" name="general_condition"
                                       value="{{$i}}"> {{ Config::get('product.conditions.general_condition')[$i] }}
                            </label>
                        @endfor
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

                        @for ($i = 0; $i < 3; $i++)
                            <label class="btn btn-default condition-btn
                                @if ($product->condition->highlights_and_notes == $i) active @endif">
                                <input type="radio" name="highlights_and_notes"
                                       value="{{$i}}"> {{ Config::get('product.conditions.highlights_and_notes')[$i] }}
                            </label>
                        @endfor
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
                        @for($i = 0; $i < 3; $i++)
                            <label class="btn btn-default condition-btn
                                @if ($product->condition->damaged_pages == $i) active @endif">
                                <input type="radio" name="damaged_pages"
                                       value="{{$i}}"> {{ Config::get('product.conditions.damaged_pages')[$i] }}
                            </label>
                        @endfor
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
                        @for($i = 0; $i < 2; $i++)
                            <label class="btn btn-default condition-btn
                                @if ($product->condition->broken_binding == $i) active @endif">
                                <input type="radio" name="broken_binding"
                                       value="{{$i}}"> {{ Config::get('product.conditions.broken_binding')[$i] }}
                            </label>
                        @endfor
                    </div>
                </div>

                {{-- Description --}}
                <div class="form-group">
                    <label>{{ Config::get('product.conditions.description.title') }}</label>
                    <textarea name="description" class="form-control" rows="5"
                              placeholder="{{ Config::get('product.conditions.description.place_holder') }}">{{ $product->condition->description }}</textarea>
                </div>
                {{-- Price --}}

                {{-- list price --}}
                {{--@if($book->list_price)--}}
                {{--<div>List price: ${{ $book->list_price }}</div>--}}
                {{--@endif--}}

                {{-- your price --}}
                <div class="form-group">
                    <label>Price</label>

                    <div class="input-group" id="price-input">
                        <div class="input-group-addon">$</div>
                        <input type="number" step="0.01" name="price" class="form-control" id="price-form"
                               value="{{ $product->decimalPrice() }}" placeholder="Amount">
                    </div>
                </div>

                {{-- Upload Images using Dropzone --}}
                <div class="form-group">
                    <label>Upload Textbook Image</label>

                    <div id="dropzone-img-preview" class="dropzone-previews dz-clickable">
                        <div class="dz-message">
                            Drop images here or click to upload.
                            <br>
                            <small>(A front cover image is required. You can upload three images in maximum, at most 3MB per image.)</small>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn primary-btn sell-btn">Update</button>
            </form>
        </div>
    </div>
@endsection

@section('javascript')
    <script src="{{ asset('libs/dropzone/dist/min/dropzone.min.js') }}"></script>
    {{--<script src="{{ asset('libs-paid/formvalidation-dist-v0.6.3/dist/js/formValidation.min.js') }}"></script>--}}
    {{--<script src="{{ asset('libs-paid/formvalidation-dist-v0.6.3/dist/js/framework/bootstrap.min.js') }}"></script>--}}
    <script src="{{ asset('js/product/edit.js') }}"></script>
@endsection
