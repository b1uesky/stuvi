{{--/textbook/sell/product/create/#--}}

@extends('app')

@section('title', 'Enter Product Info')

@section('css')
    <link rel="stylesheet" href="{{ asset('libs/dropzone/dist/min/dropzone.min.css') }}">
    <link href="{{ asset('/css/product_create.css') }}" rel="stylesheet">
@endsection

@section('content')
    @include('includes.textbook.flash-message')

    {{-- Errors for invalid data --}}
    {{--@if ($errors->has())--}}
    {{--<div class="alert alert-danger">--}}
    {{--@foreach ($errors->all() as $error)--}}
    {{--{{ $error }}<br>--}}
    {{--@endforeach--}}
    {{--</div>--}}
    {{--@endif--}}

    <div class="container">
        {{--<div class="row">--}}
            {{--<div class="col-md-8 col-md-offset-2">--}}
                {{--<div class="page-header">--}}
                    {{--<h1>Post Your Book</h1>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}

        <section class="confirm">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-presentation">
                        <div class="panel-heading">
                            <h2>Confirm Your Book</h2>
                        </div>
                        <div class="panel-body">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-xs-4">
                                        @if($book->imageSet->large_image)
                                            <img class="img-responsive"
                                                 src="{{ config('aws.url.stuvi-book-img') . $book->imageSet->large_image }}">
                                        @else
                                            <img class="img-responsive"
                                                 src="{{ config('book.default_image_path.large') }}"/>
                                        @endif
                                    </div>

                                    <div class="col-xs-8">
                                        <h4>{{ $book->title }}</h4>

                                        <table class="table table-book-details">
                                            <tr>
                                                <th>
                                                    @if(count($book->authors) > 1)
                                                        Authors:
                                                    @else
                                                        Author:
                                                    @endif
                                                </th>
                                                <td>
                                                    @foreach($book->authors as $index => $author)
                                                        @if($index == 0)
                                                            {{ $author->full_name }}
                                                        @else
                                                            , {{ $author->full_name }}
                                                        @endif
                                                    @endforeach
                                                </td>
                                            </tr>

                                            <tr>
                                                <th>
                                                    ISBN-10:
                                                </th>
                                                <td>
                                                    {{ $book->isbn10 }}
                                                </td>
                                            </tr>

                                            <tr>
                                                <th>
                                                    ISBN-13:
                                                </th>
                                                <td>
                                                    {{ $book->isbn13 }}
                                                </td>
                                            </tr>

                                            <tr>
                                                <th>
                                                    Number of Pages:
                                                </th>
                                                <td>
                                                    {{ $book->num_pages }}
                                                </td>
                                            </tr>
                                        </table>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="panel-footer">
                            <div class="row">
                                <div class="col-sm-6">
                                    <a href="{{ url('textbook/sell') }}" class="btn muted-btn btn-block">
                                        No, this is not the book I want to sell.
                                    </a>
                                </div>
                                <div class="col-sm-6">
                                    <a href="#" class="btn primary-btn btn-block btn-to-details">Continue</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="row">
            {{-- form --}}
            <div class="col-md-8 col-md-offset-2">
                {{--If the user is not logged in, show login / signup buttons.--}}
                @if(!Auth::check())
                    <div class="row">
                        <p>Please login or sign up to sell your book.</p>
                        <a class="btn primary-btn" data-toggle="modal" href="#login-modal">Login</a>&nbsp;
                        <a class="btn primary-btn" data-toggle="modal" href="#signup-modal">Sign up</a>
                    </div>
                @else
                    <form id="form-product" class="dropzone">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="book_id" value="{{ $book->id }}"/>
                        <input type="hidden" name="book_title" value="{{ $book->title }}">

                        <section class="details hidden">
                            <div class="panel panel-presentation">
                                <div class="panel-heading">
                                    <h2>Complete Book Details</h2>
                                </div>

                                <div class="panel-body">
                                    <div class="container-fluid">

                                        {{--General Condition--}}
                                        <div class="form-group">
                                            <label>{{ Config::get('product.conditions.general_condition.title') }}</label>
                                            {{--Open modal button--}}
                                            <i class="fa fa-question-circle" data-toggle="modal"
                                               data-target=".condition-modal"></i>
                                            <br>
                                            {{--General Condition Modal--}}
                                            <div class="modal fade condition-modal" tabindex="-1" role="dialog"
                                                 aria-labelledby="General Conditions">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close close-modal-btn"
                                                                    data-dismiss="modal" aria-label="close">
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
                                            {{--General Conditon Buttons--}}
                                            <div class="btn-group btn-group-justified" data-toggle="buttons">
                                                @for ($i = 0; $i < 4; $i++)
                                                    <label class="btn btn-default">
                                                        <input type="radio" name="general_condition"
                                                               value="{{$i}}"> {{ Config::get('product.conditions.general_condition')[$i] }}
                                                    </label>
                                                @endfor
                                            </div>
                                        </div>

                                        {{--Highlights/Notes--}}
                                        <div class="form-group">
                                            <label>{{ Config::get('product.conditions.highlights_and_notes.title') }}</label>
                                            {{--Open modal button--}}
                                            <i class="fa fa-question-circle" data-toggle="modal"
                                               data-target=".highlight-modal"></i>
                                            <br>
                                            {{--Highlights / Notes modal--}}
                                            <div class="modal fade highlight-modal" tabindex="-1" role="dialog"
                                                 aria-labelledby="Highlights/Notes">
                                                <div class="modal-dialog modal-md">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close close-modal-btn"
                                                                    data-dismiss="modal" aria-label="close">
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
                                            {{--Highlights / Notes buttons--}}
                                            <div class="btn-group btn-group-justified" data-toggle="buttons">
                                                @for ($i = 0; $i < 3; $i++)
                                                    <label class="btn btn-default">
                                                        <input type="radio" name="highlights_and_notes"
                                                               value="{{$i}}"> {{ Config::get('product.conditions.highlights_and_notes')[$i] }}
                                                    </label>
                                                @endfor
                                            </div>
                                        </div>

                                        {{--Damaged Pages--}}
                                        <div class="form-group">
                                            <label>{{ Config::get('product.conditions.damaged_pages.title') }}</label>
                                            <i class="fa fa-question-circle" data-toggle="modal"
                                               data-target=".damage-modal"></i>
                                            <br>
                                            {{--Damaged pages modal--}}
                                            <div class="modal fade damage-modal" tabindex="-1" role="dialog"
                                                 aria-labelledby="Damaged Pages">
                                                <div class="modal-dialog modal-md">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close close-modal-btn"
                                                                    data-dismiss="modal" aria-label="close">
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
                                            {{--Damaged pages buttons--}}
                                            <div class="btn-group btn-group-justified" data-toggle="buttons">
                                                @for($i = 0; $i < 3; $i++)
                                                    <label class="btn btn-default">
                                                        <input type="radio" name="damaged_pages"
                                                               value="{{$i}}"> {{ Config::get('product.conditions.damaged_pages')[$i] }}
                                                    </label>
                                                @endfor
                                            </div>
                                        </div>

                                        {{--Broken Binding--}}
                                        <div class="form-group">
                                            <label>{{ Config::get('product.conditions.broken_binding.title') }}</label>
                                            <i class="fa fa-question-circle" data-toggle="modal"
                                               data-target=".binding-modal"></i>
                                            <br>
                                            {{--Broken binding modal--}}
                                            <div class="modal fade binding-modal" tabindex="-1" role="dialog"
                                                 aria-labelledby="Broken Binding">
                                                <div class="modal-dialog modal-md">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close close-modal-btn"
                                                                    data-dismiss="modal"
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
                                            {{--Broken binding buttons--}}
                                            <div class="btn-group btn-group-justified" data-toggle="buttons">
                                                @for($i = 0; $i < 2; $i++)
                                                    <label class="btn btn-default">
                                                        <input type="radio" name="broken_binding"
                                                               value="{{$i}}"> {{ Config::get('product.conditions.broken_binding')[$i] }}
                                                    </label>
                                                @endfor
                                            </div>
                                        </div>

                                        {{--Description--}}
                                        <div class="form-group">
                                            {{--<label>{{ Config::get('product.conditions.description.title') }}</label>--}}
                                            <textarea name="description" class="form-control" rows="5"
                                                      placeholder="{{ Config::get('product.conditions.description.placeholder') }}"></textarea>
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
                                    </div>
                                </div>

                                <div class="panel-footer">
                                    <div class="row">
                                        <div class="col-sm-6 col-sm-offset-3">
                                            <a href="#" class="btn primary-btn btn-block btn-to-ready">Continue</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <section class="ready hidden">
                            <div class="panel panel-presentation">
                                <div class="panel-heading">
                                    <h2>Ready to Go!</h2>
                                </div>
                                <div class="panel-body">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-md-6 col-md-offset-3">
                                                {{--your price--}}
                                                <div class="form-group">
                                                    <label>Price</label>

                                                    <div class="input-group">
                                                        <div class="input-group-addon">$</div>
                                                        <input type="number" step="0.01" min="0.00" name="price"
                                                               class="form-control" placeholder="Amount">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 col-md-offset-3">
                                                {{--Paypal account--}}
                                                <div class="form-group">
                                                    <label>Paypal Account</label>
                                                    <input type="email" name="paypal" class="form-control"
                                                           value="{{ $paypal or '' }}" placeholder="Paypal email address">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 col-md-offset-3">
                                                <input type="submit" name="submit" class="btn primary-btn btn-block" value="Post book">
                                            </div>
                                        </div>
                                        <div class="tos-privacy-container">
                                            <br>
                                            <small>By posting your book, you agree to Stuvi's
                                                <a href="#" data-toggle="modal" data-target="#terms-modal">Terms of Service</a>
                                                and <a href="#" data-toggle="modal" data-target="#privacy-modal"> Privacy Notice</a>.</small>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </section>
                    </form>
                @endif


            </div>
        </div>
    </div>

@endsection

@section('modals')
    @include('includes.textbook.tos-privacy-modal')
@endsection

@section('javascript')
    <script src="{{ asset('libs/dropzone/dist/min/dropzone.min.js') }}"></script>

    @if(Auth::check())
        {{-- FormValidation --}}
        {{--<script src="{{ asset('libs-paid/formvalidation-dist-v0.6.3/dist/js/formValidation.min.js') }}"></script>--}}
        {{--<script src="{{ asset('libs-paid/formvalidation-dist-v0.6.3/dist/js/framework/bootstrap.min.js') }}"></script>--}}
        <script src="{{ asset('js/product/create.js') }}"></script>
    @endif
@endsection
