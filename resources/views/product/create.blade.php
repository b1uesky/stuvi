{{--/textbook/sell/product/create/#--}}

@extends('layouts.textbook')

@section('title', 'Sell your book')

@section('content')

    <div class="container">

        <div class="row">
            <div class="col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
                <div class="row">
                    <ol class="breadcrumb">
                        <li><a href="{{ url('/') }}">Home</a></li>
                        <li><a href="{{ url('textbook/sell/product/' . $book->id . '/confirm') }}">Confirm</a></li>
                        <li class="active">Sell your book</li>
                    </ol>
                </div>

                <div class="page-header">
                    <h1>Sell your book</h1>
                </div>

                <div class="row">
                    @if(Auth::check())
                        <form id="form-create-product" class="dropzone form-product">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="book_id" value="{{ $book->id }}"/>
                            <input type="hidden" name="book_title" value="{{ $book->title }}">

                            <div class="panel panel-presentation">
                                    <div class="panel-body">

                                        {{--General Condition--}}
                                        <div class="form-group">
                                            <label>General condition</label>
                                            {{--Open modal button--}}
                                            <span class="glyphicon glyphicon-question-sign text-muted cursor-pointer" data-toggle="modal"
                                                  data-target=".condition-modal"></span>

                                            <div class="radio-button-group">
                                                <label class="radio-inline">
                                                    <input type="radio" name="general_condition" value="0">
                                                    <span>Like new</span>
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="general_condition" value="1">
                                                    <span>Good</span>
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="general_condition" value="2">
                                                    <span>Acceptable</span>
                                                </label>
                                            </div>

                                        </div>

                                        {{--Highlights/Notes--}}
                                        <div class="form-group">
                                            <label>Highlights/Notes</label>
                                            {{--Open modal button--}}
                                            <span class="glyphicon glyphicon-question-sign text-muted cursor-pointer" data-toggle="modal"
                                               data-target=".highlight-modal"></span>

                                            <div class="radio-button-group">
                                                <label class="radio-inline">
                                                    <input type="radio" name="highlights_and_notes" value="0">
                                                    <span>0 ~ 5 pages</span>
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="highlights_and_notes" value="1">
                                                    <span>6 ~ 15 pages</span>
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="highlights_and_notes" value="2">
                                                    <span>> 15 pages</span>
                                                </label>
                                            </div>

                                        </div>

                                        {{--Damaged Pages--}}
                                        <div class="form-group">
                                            <label>Damaged pages</label>
                                            <span class="glyphicon glyphicon-question-sign text-muted cursor-pointer" data-toggle="modal"
                                               data-target=".damage-modal"></span>

                                            <div class="radio-button-group">
                                                <label class="radio-inline">
                                                    <input type="radio" name="damaged_pages" value="0">
                                                    <span>0</span>
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="damaged_pages" value="1">
                                                    <span>1 ~ 3 pages</span>
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="damaged_pages" value="2">
                                                    <span>> 3 pages</span>
                                                </label>
                                            </div>
                                        </div>

                                        {{--Broken Binding--}}
                                        <div class="form-group">
                                            <label>Broken book binding</label>
                                            <span class="glyphicon glyphicon-question-sign text-muted cursor-pointer" data-toggle="modal"
                                               data-target=".binding-modal"></span>

                                            <div class="radio-button-group">
                                                <label class="radio-inline">
                                                    <input type="radio" name="broken_binding" value="0">
                                                    <span>No</span>
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="broken_binding" value="1">
                                                    <span>Yes</span>
                                                </label>
                                            </div>
                                        </div>

                                        {{--Description--}}
                                        <div class="form-group">
                                            <label>Additional description <small>(optional)</small></label>
                                            <textarea name="description" class="form-control" rows="3"
                                                      placeholder="More description on your book conditions."></textarea>
                                        </div>

                                        {{--Upload Images using Dropzone--}}
                                        <div class="form-group">
                                            <div id="dropzone-img-preview" class="dropzone-previews dz-clickable">
                                                <div class="dz-message">
                                                    <h4>
                                                        <span class="glyphicon glyphicon-picture"></span>
                                                        Drop or click here to upload textbook images.
                                                    </h4>
                                                    <br>
                                                    <p class="text-muted">A front cover image is required.</p>
                                                    <p class="text-muted">You can upload a maximum of
                                                        three images, at most 3MB per image.</p>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Availability --}}
                                        <div class="from-group">
                                            <label>When is it available?</label>

                                            <div class="radio-button-group">
                                                <label class="radio-inline">
                                                    <input type="radio" name="available_at" id="available_now" value="" checked>
                                                    <span>Now</span>
                                                </label>

                                                <label class="radio-inline">
                                                    <input type="radio" name="available_at" id="available_future" value="">
                                                    <span>In the future</span>
                                                </label>
                                            </div>

                                            <div id="datetimepicker-available-date" class="hidden"></div>

                                        </div>

                                        {{--your price--}}
                                        <div class="form-group" id="sale-price">
                                            <label>Sale price</label>

                                            <div class="input-group">
                                                <div class="input-group-addon">$</div>
                                                <input type="number" step="0.01" min="0.00" name="price"
                                                       class="form-control" placeholder="Set a price for your book">
                                            </div>
                                        </div>

                                        {{-- Receive money --}}
                                        <div class="form-group">
                                            <label>Receive money</label>

                                            <div class="radio-button-group">
                                                <label class="radio-inline">
                                                    <input type="radio" name="payout_method" id="payout_paypal" value="paypal">
                                                    <span>PayPal</span>
                                                </label>

                                                <label class="radio-inline">
                                                    <input type="radio" name="payout_method" id="payout_cash" value="cash">
                                                    <span>Cash</span>
                                                </label>
                                            </div>


                                        </div>

                                        {{--Paypal account--}}
                                        <div class="form-group hidden" id="paypal_account">
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

                                        {{-- Sell to --}}
                                        <div class="form-group">
                                            <div class="checkbox">
                                                <label for="">
                                                    <input type="checkbox" name="accept_trade_in" checked>
                                                    I would like to join the Stuvi Book Trade-In program
                                                    <span class="glyphicon glyphicon-question-sign" id="book-trade-in-popover"></span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <small>By posting your book, you agree to Stuvi's
                                                <a href="#" data-toggle="modal" data-target="#terms-modal">Terms of Service</a>
                                                and <a href="#" data-toggle="modal" data-target="#privacy-modal"> Privacy Notice</a>.</small>
                                        </div>

                                        <input type="submit" name="submit" class="btn btn-lg btn-primary center-block" value="Submit">
                                    </div>
                                </div>
                        </form>
                    @endif
                </div>

            </div>
        </div>
    </div>

    @include('includes.modal.product-conditions')

@endsection
