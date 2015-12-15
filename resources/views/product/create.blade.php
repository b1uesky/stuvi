{{--/textbook/sell/product/create/#--}}

@extends('layouts.textbook')

@section('title', 'Sell your book')

@section('content')

    <div class="container">

        <div class="row">
            <ol class="breadcrumb">
                <li><a href="{{ url('/') }}">Home</a></li>
                <li><a href="{{ url('textbook/confirm/'.$book->id) }}">Confirm</a></li>
                <li class="active">Sell your book</li>
            </ol>
        </div>

        <div class="page-header">
            <h1>Sell your book</h1>
        </div>

        <form id="form-create-product" class="dropzone form-product form-horizontal">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="book_id" value="{{ $book->id }}"/>
                <input type="hidden" name="book_title" value="{{ $book->title }}">


                {{--General Condition--}}
                <div class="form-group">
                <label class="col-md-3 col-sm-4 controll-label">General condition <span
                            class="glyphicon glyphicon-question-sign"
                            id="book-general-condition-popover"></span></label>

                <div class="col-md-9 col-sm-8">
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
            </div>

                <br>

                {{--Highlights/Notes--}}
                <div class="form-group">
                    <label class="col-md-3 col-sm-4 controll-label">Highlights/Notes <span
                                class="glyphicon glyphicon-question-sign"
                                id="book-highlights-notes-popover"></span></label>

                    <div class="col-md-9 col-sm-8">
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
                </div>

                <br>

                {{--Damaged Pages--}}
                <div class="form-group">
                    <label class="col-md-3 col-sm-4 controll-label">Damaged pages <span class="glyphicon glyphicon-question-sign"
                                                                               id="book-damaged-pages-popover"></span></label>

                    <div class="col-md-9 col-sm-8">
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

                </div>

                <br>

                {{--Broken Binding--}}
                <div class="form-group">
                    <label class="col-md-3 col-sm-4 controll-label">Broken book binding <span
                                class="glyphicon glyphicon-question-sign"
                                id="book-broken-binding-popover"></span></label>

                    <div class="col-md-9 col-sm-8">
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
                </div>

                <br>

                {{--Description--}}
                <div class="form-group">
                    <label class="col-md-3 col-sm-4 controll-label">Additional description
                        <small>(optional)</small>
                    </label>

                    <div class="col-md-9 col-sm-8">
                        <textarea name="description" class="form-control" rows="3"
                                  placeholder="More description on your book conditions."></textarea>
                    </div>
                </div>

                <br>

                {{--Upload Images using Dropzone--}}
                <div class="form-group">
                    <label class="col-md-3 col-sm-4 controll-label">Upload textbook photos</label>

                    <div class="col-md-9 col-sm-8">
                        <div id="dropzone-img-preview" class="dropzone-previews dz-clickable">
                            <div class="dz-message">
                                <h4>
                                    <span class="glyphicon glyphicon-camera"></span>
                                    Drop or click here to upload photos.
                                </h4>
                                <br>

                                <p class="text-muted">A real front cover photo is required in order to help others better understand your book conditions.</p>
                                <p class="text-muted">You can upload a maximum of 3 images, at most 3MB per image.</p>
                            </div>
                        </div>
                    </div>

                </div>

                <br>

                {{-- Availability --}}
                <div class="form-group">
                    <label class="col-md-3 col-sm-4 controll-label">When is it available?</label>

                    <div class="col-md-9 col-sm-8">
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

                </div>

                <br>

                {{--your price--}}
                <div class="form-group" id="sale-price">
                    <label class="col-md-3 col-sm-4 controll-label">Price your book</label>

                    <div class="col-md-9 col-sm-8">
                        <div class="input-group">
                            <div class="input-group-addon">$</div>
                            <input type="number" step="0.01" min="0.00" name="price"
                                   class="form-control" placeholder="Set a price for your book">
                        </div>
                    </div>
                </div>

                <br>

                {{-- Receive money --}}
                <div class="form-group">
                    <label class="col-md-3 col-sm-4 controll-label">Receiving payment <span
                                class="glyphicon glyphicon-question-sign" id="receiving-payment-popover"></span></label>

                    <div class="col-md-9 col-sm-8">
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
                </div>

                <br>

                {{--Paypal account--}}
                <div class="form-group hidden" id="paypal_account">
                    <label class="col-md-3 col-sm-4 controll-label">
                        <span>Paypal account</span>
                        <br>
                        <small>
                            <a href="https://www.paypal.com/us/signup/account"
                               target="_blank">No Paypal account?</a>
                        </small>
                    </label>

                    <div class="col-md-9 col-sm-8">
                        <input type="email" name="paypal" class="form-control"
                               value="{{ $paypal or '' }}" placeholder="Paypal email address">

                        <small class="text-muted">A $0.25 PayPal transaction fee will be deducted from your receiving payment.</small>
                    </div>

                </div>

                {{-- Join trade-in program --}}
                <div class="form-group">
                    <div class="col-md-offset-3 col-md-9 col-sm-offset-4 col-sm-8">
                        <div class="checkbox">
                            <label for="">
                                <input type="checkbox" name="accept_trade_in" checked>
                                I would like to join the <a href="{{ url('trade-in-program') }}" target="_blank">Stuvi Book Trade-In Program</a>.
                                <span class="glyphicon glyphicon-question-sign" id="book-trade-in-popover"></span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-offset-3 col-md-9 col-sm-offset-4 col-sm-8">
                        By posting your book, you agree to Stuvi's
                            <a href="#" data-toggle="modal" data-target="#terms-modal">Terms of Service</a>
                            and <a href="#" data-toggle="modal" data-target="#privacy-modal"> Privacy Notice</a>.
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-offset-3 col-md-9 col-sm-offset-4 col-sm-8">
                        <input type="submit" name="submit" class="btn btn-lg btn-primary" value="Submit">
                    </div>
                </div>

            </form>

    </div>

@endsection
