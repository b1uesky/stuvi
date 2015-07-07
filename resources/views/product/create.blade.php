{{--/textbook/sell/product/create/#--}}

@extends('app')

@section('content')
    <head>
        <link href="{{ asset('/css/product/product-create.css') }}" rel="stylesheet">
        <title>Enter book info</title>
    </head>

    <div class="container create-container">
        <div class="row textbook-row col-sm-5">
            <div>
                @if($book->imageSet->large_image)
                    <img id="textbook-img" src="{{ $book->imageSet->large_image }}" alt=""/>
                @endif
            </div>

            <div class="textbook-info">
                <h1>{{ $book->title }}</h1>

                <div class="authors-container">
                    <span>by </span>
                    @foreach($book->authors as $author)
                        <span id="authors"><button class="btn btn-default author-btn">{{ $author->full_name }}</button></span>
                    @endforeach
                </div>
                <p>ISBN-10: {{ $book->isbn10 }}</p>
                <p>ISBN-13: {{ $book->isbn13 }}</p>
                <p>Edition: {{ $book->edition }}</p>
                <p>Number of Pages: {{ $book->num_pages }}</p>
            </div>
        </div>
        <div class="row col-sm-6 col-sm-offset-1">
            <h2>Book Conditions</h2>

            <form action="/textbook/sell/product/store" method="post" enctype="multipart/form-data">
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
                                    <h3>Highlights/Notes</h3>
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
                                    <h3>Damaged Pages</h3>
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
                    <label>{{ $conditions['broken_binding']['title'] }}</label>
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
                                    <h3>Broken Binding</h3>
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
                <div class="form-group">
                    <label>Price</label>
                    <input type="number" step="0.01" name="price" class="form-control">
                </div>

                {{-- Upload Images --}}
                <div class="form-group">
                    <label>Upload images</label>
                    <input type="file" name="images[]" multiple>
                </div>
                <input type="submit" name="submit" class="btn sell-btn" value="Sell Book"/>
            </form>
        </div>
    </div>
@endsection

@section('javascript')
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
@endsection
