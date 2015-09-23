{{--/textbook/sell/product/create/#--}}

@extends('layouts.textbook')

@section('title', 'Enter Product Info')

@section('content')

    <div class="container">

        <div class="row">
            <div class="col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
                <div class="row">
                    <ol class="breadcrumb">
                        <li><a href="{{ url('textbook/sell') }}">Home</a></li>
                        <li><a href="{{ url('textbook/sell/product/' . $book->id . '/confirm') }}">Confirm</a></li>
                        <li class="active">Post your book</li>
                    </ol>
                </div>

                <div class="page-header">
                    <h2>Post your book</h2>
                </div>

                <div class="row">
                    @if(Auth::check())
                        <form id="form-product" class="dropzone">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="book_id" value="{{ $book->id }}"/>
                            <input type="hidden" name="book_title" value="{{ $book->title }}">

                            <section class="details">
                                <div class="panel panel-presentation">

                                    <div class="panel-body">

                                            {{--General Condition--}}
                                            <div class="form-group">
                                                <label>General condition</label>
                                                {{--Open modal button--}}
                                                <span class="glyphicon glyphicon-question-sign" data-toggle="modal"
                                                      data-target=".condition-modal"></span>
                                                <br>

                                                <div class="radio-product-condition">
                                                    <label class="radio-inline">
                                                        <input type="radio" name="general_condition" value="0"> Brand new
                                                    </label>
                                                    <label class="radio-inline">
                                                        <input type="radio" name="general_condition" value="1"> Excellent
                                                    </label>
                                                    <label class="radio-inline">
                                                        <input type="radio" name="general_condition" value="2"> Good
                                                    </label>
                                                    <label class="radio-inline">
                                                        <input type="radio" name="general_condition" value="3"> Acceptable
                                                    </label>
                                                </div>
                                            </div>

                                            {{--Highlights/Notes--}}
                                            <div class="form-group">
                                                <label>Highlights/Notes</label>
                                                {{--Open modal button--}}
                                                <span class="glyphicon glyphicon-question-sign" data-toggle="modal"
                                                   data-target=".highlight-modal"></span>
                                                <br>

                                                <div class="radio-product-condition">
                                                    <label class="radio-inline">
                                                        <input type="radio" name="highlights_and_notes" value="0"> 0 - 5 pages
                                                    </label>
                                                    <label class="radio-inline">
                                                        <input type="radio" name="highlights_and_notes" value="1"> 6 - 15 pages
                                                    </label>
                                                    <label class="radio-inline">
                                                        <input type="radio" name="highlights_and_notes" value="2"> > 15 pages
                                                    </label>
                                                </div>
                                            </div>

                                            {{--Damaged Pages--}}
                                            <div class="form-group">
                                                <label>Damaged pages</label>
                                                <span class="glyphicon glyphicon-question-sign" data-toggle="modal"
                                                   data-target=".damage-modal"></span>
                                                <br>

                                                <div class="radio-product-condition">
                                                    <label class="radio-inline">
                                                        <input type="radio" name="damaged_pages" value="0"> 0
                                                    </label>
                                                    <label class="radio-inline">
                                                        <input type="radio" name="damaged_pages" value="1"> 1 - 3 pages
                                                    </label>
                                                    <label class="radio-inline">
                                                        <input type="radio" name="damaged_pages" value="2"> > 3 pages
                                                    </label>
                                                </div>
                                            </div>

                                            {{--Broken Binding--}}
                                            <div class="form-group">
                                                <label>Broken book binding</label>
                                                <span class="glyphicon glyphicon-question-sign" data-toggle="modal"
                                                   data-target=".binding-modal"></span>
                                                <br>

                                                <div class="radio-product-condition">
                                                    <label class="radio-inline">
                                                        <input type="radio" name="broken_binding" value="0"> No
                                                    </label>
                                                    <label class="radio-inline">
                                                        <input type="radio" name="broken_binding" value="1"> Yes
                                                    </label>
                                                </div>
                                            </div>

                                            {{--Description--}}
                                            <div class="form-group">
                                                <label>{{ config('product.conditions.description.title') }}</label>
                                                <textarea name="description" class="form-control" rows="5"
                                                          placeholder="{{ config('product.conditions.description.placeholder') }}"></textarea>
                                            </div>

                                            {{--Upload Images using Dropzone--}}
                                            <div class="form-group">
                                                {{--<label>Upload Textbook Image</label>--}}

                                                <div id="dropzone-img-preview" class="dropzone-previews dz-clickable">
                                                    <div class="dz-message">
                                                        <h4>Drop or click here to upload textbook images.</h4>
                                                        <br>
                                                        <small class="text-muted">(A front cover image is required. You can upload a maximum of
                                                            three images, at most 3MB per image.)
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>

                                            {{--your price--}}
                                            <div class="form-group">
                                                <label>Sale price</label>

                                                <div class="input-group">
                                                    <div class="input-group-addon">$</div>
                                                    <input type="number" step="0.01" min="0.00" name="price"
                                                           class="form-control" placeholder="Set a sale price for your book">
                                                </div>
                                            </div>

                                            {{--Paypal account--}}
                                            <div class="form-group">
                                                <label class="full-width">
                                                    <span>Paypal account</span>
                                                        <span class="pull-right">
                                                            <small>
                                                                <a href="https://www.paypal.com/us/signup/account" target="_blank">No Paypal account?</a>
                                                            </small>
                                                        </span>
                                                </label>


                                                <input type="email" name="paypal" class="form-control"
                                                       value="{{ $paypal or '' }}" placeholder="Paypal email address">
                                            </div>

                                            <div class="form-group">
                                                <small>By posting your book, you agree to Stuvi's
                                                    <a href="#" data-toggle="modal" data-target="#terms-modal">Terms of Service</a>
                                                    and <a href="#" data-toggle="modal" data-target="#privacy-modal"> Privacy Notice</a>.</small>
                                            </div>

                                            <input type="submit" name="submit" class="btn btn-lg btn-primary center-block" value="Upload images and post book">
                                    </div>
                                </div>
                            </section>
                        </form>
                    @endif
                </div>

            </div>
        </div>
    </div>

    @include('includes.modal.product-conditions')

@endsection
