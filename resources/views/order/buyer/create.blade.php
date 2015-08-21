{{-- Checkout page --}}

@extends('app')

@section('title', 'Checkout')

@section('css')
    <link href="{{ asset('/css/order_buyer_create.css') }}" rel="stylesheet">
@endsection

@section('content')

    @include('includes.textbook.flash-message')

    <div class="container container-main-content">
        {!! Breadcrumbs::render('shoppingCart') !!}

        <div class="row">
            <div class="col-md-8">
                <div class="checkout-body">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <strong>Whoops!</strong> There were some problems with your input.<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>

                {{-- Shipping address --}}
                <div class="row">
                    <h2>1 Shipping address</h2>

                    @forelse ($addresses as $address)
                        @if ($address -> is_default)
                            <div class="thumbnail col-md-4 displayDefaultAddress">
                                <div class="panel-body">
                                    <ul class="address-list" id="default-address-list">
                                        <li class="address addressee">{{ $address -> addressee }}</li>
                                        <li class="address address_line1">{{ $address -> address_line1}}</li>
                                        @if($address -> address_line2 != null)
                                            <li class="address address_line2">{{ $address -> address_line2}}</li>
                                        @endif
                                        <li class="address inline city">{{ $address -> city }},</li>
                                        <li class="address inline state_a2">{{ $address -> state_a2 }}</li>
                                        <li class="address inline zip">{{ $address -> zip }}</li>
                                        <li class="address phone">{{ $address -> phone_number }}</li>
                                    </ul>
                                    <button class="btn btn-default primary-btn address-btn show-addresses">Change
                                        Address
                                    </button>
                                </div>
                            </div>
                        @endif
                        <div class="thumbnail col-md-8 displayAllAddresses {{ $address -> id }}"
                             style={{$default_address_id != -1 ? "display:none" : ""}}>
                            <div class="panel-body">
                            <button type="button" class="close deleteThisAddress" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <ul class="address-list all-addresses-list">
                                    <li class="address address_id">{{ $address -> id }}</li>
                                    <li class="address addressee">{{ $address -> addressee }}</li>
                                    <li class="address address_line1">{{ $address -> address_line1}}</li>
                                    @if($address -> address_line2 != null)
                                        <li class="address address_line2">{{ $address -> address_line2}}</li>
                                    @endif
                                    <li class="address city inline">{{ $address -> city }},</li>
                                    <li class="address state_a2 inline"
                                        id="default_state_a2">{{ $address -> state_a2 }}</li>
                                    <li class="address zip inline">{{ $address -> zip }}</li>
                                    <li class="address phone">{{ $address -> phone_number }}</li>
                                </ul>
                                <button class="btn btn-default primary-btn address-btn editThisAddress">
                                    Edit
                                </button>
                            </div>
                        </div>
                    @empty
                        <form action="{{ url('/address/store') }}" method="POST"
                              class="address-form">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group">
                                <label class="col-sm-4 control-label" for="addressee-input">Full name</label>

                                <div class="col-sm-6 form-space-offset">
                                    <input type="text" class="form-control" name="addressee" id="addressee-input"
                                           value="{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}">
                                </div>
                            </div>
                            <br>

                            <div class="form-group">
                                <label class="col-sm-4 control-label" for="address_line1-input">Address line
                                    1</label>

                                <div class="col-sm-6 form-space-offset">
                                    <input type="text" class="form-control" name="address_line1"
                                           id="address_line1-input"
                                           value="185 Freeman St.">
                                </div>
                            </div>
                            <br>

                            <div class="form-group">
                                <label class="col-sm-4 control-label" for="address_line2-input">Address line
                                    2</label>

                                <div class="col-sm-6 form-space-offset">
                                    <input type="text" class="form-control" name="address_line2"
                                           id="address_line2-input"
                                           value="Apt. 739">
                                </div>
                            </div>
                            <br>

                            <div class="form-group">
                                <label class="col-sm-4 control-label" for="city-input">City</label>

                                <div class="col-sm-6 form-space-offset">
                                    <input type="text" class="form-control" name="city" id="city-input"
                                           value="Brookline">
                                </div>
                            </div>
                            <br>

                            <div class="form-group">
                                <label class="col-sm-4 control-label" for="state_a2-input">State</label>

                                <div class="col-sm-6 form-space-offset">
                                    <input type="text" class="form-control" name="state_a2" id="state_a2-input"
                                           value="MA">
                                </div>
                            </div>
                            <br>

                            <div class="form-group">
                                <label class="col-sm-4 control-label" for="zip-input">Zip</label>

                                <div class="col-sm-6 form-space-offset">
                                    <input type="text" class="form-control" name="zip" id="zip-input" value="02446">
                                </div>
                            </div>
                            <br>

                            <div class="form-group">
                                <label class="col-sm-4 control-label" for="phone_number-input">Phone</label>

                                <div class="col-sm-6 form-space-offset">
                                    <input type="tel" class="form-control phone_number" id="phone_number-input"
                                           name="phone_number" value="(857) 206 4789">
                                </div>
                            </div>
                            <br>
                            <button class="btn btn-default primary-btn address-btn" id="storeAddress"
                                    type="submit">
                                Add Address
                            </button>
                        </form>
                    @endforelse
                    <div id="new-address-panel" class="thumbnail col-sm-5">
                        <div class="panel-body">
                            <h4>Add New Address</h4>
                            <i class="fa fa-plus-square fa-4x"></i>
                        </div>
                    </div>

                    <!--Modals-->
                    <div class="modal fade" id="update-address-modal" tabindex="-1" role="dialog"
                         aria-labelledby="myModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close close-modal-btn" data-dismiss="modal"
                                            aria-label="Close">
                                        <span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="myModalLabel">Please Enter Address</h4>
                                </div>
                                <div class="modal-body address-form-body">
                                    <form action="{{ url('/address/update') }}" method="POST"
                                          id="update-address-form">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" name="address_id" value="">

                                        <div class="form-group">
                                            <label class="col-sm-4 control-label"
                                                   for="addressee-input-modal-update">Full name</label>

                                            <div class="col-sm-6 form-space-offset">
                                                <input type="text" class="form-control" name="addressee"
                                                       id="addressee-input-modal-update"
                                                       value="{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}">
                                            </div>
                                        </div>
                                        <br>

                                        <div class="form-group">
                                            <label class="col-sm-4 control-label"
                                                   for="address_line1-input-modal-update">Address line 1</label>

                                            <div class="col-sm-6 form-space-offset">
                                                <input type="text" class="form-control"
                                                       id="address_line1-input-modal-update"
                                                       name="address_line1">
                                            </div>
                                        </div>
                                        <br>

                                        <div class="form-group">
                                            <label class="col-sm-4 control-label"
                                                   for="address_line2-input-modal-update">Address line 2</label>

                                            <div class="col-sm-6 form-space-offset">
                                                <input type="text" class="form-control"
                                                       id="address_line2-input-modal-update"
                                                       name="address_line2">
                                            </div>
                                        </div>
                                        <br>

                                        <div class="form-group">
                                            <label class="col-sm-4 control-label"
                                                   for="city-input-modal-update">City</label>

                                            <div class="col-sm-6 form-space-offset">
                                                <input type="text" class="form-control" name="city"
                                                       id="city-input-modal-update">
                                            </div>
                                        </div>
                                        <br>

                                        <div class="form-group">
                                            <label class="col-sm-4 control-label" for="state_a2-input-modal-update">State</label>

                                            <div class="col-sm-6 form-space-offset">
                                                <input type="text" class="form-control" name="state_a2"
                                                       id="state_a2-input-modal-update">
                                            </div>
                                        </div>
                                        <br>

                                        <div class="form-group">
                                            <label class="col-sm-4 control-label"
                                                   for="zip-input-modal-update">Zip</label>

                                            <div class="col-sm-6 form-space-offset">
                                                <input type="text" class="form-control" name="zip"
                                                       id="zip-input-modal-update">
                                            </div>
                                        </div>
                                        <br>

                                        <div class="form-group">
                                            <label class="col-sm-4 control-label"
                                                   for="phone_number-input-update">Phone</label>

                                            <div class="col-sm-6 form-space-offset">
                                                <input type="tel" class="form-control phone_number"
                                                       id="phone_number-input-update"
                                                       name="phone_number">
                                            </div>
                                        </div>
                                        <input type="hidden" name="address_id" value="">
                                        <br>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default close-btn" data-dismiss="modal">
                                        Close
                                    </button>
                                    <i class="fa fa-spinner fa-pulse fa-2x" id="update-loading"></i>
                                    <button id="storeUpdatedAddress" type="button"
                                            class="btn btn-default primary-btn address-btn form-btn">
                                        Update Address
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="add-address-modal" tabindex="-1" role="dialog"
                         aria-labelledby="myModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close close-modal-btn" data-dismiss="modal"
                                            aria-label="Close">
                                        <span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="myModalLabel">Please Enter Address</h4>
                                </div>
                                <div class="modal-body address-form-body">
                                    <form action="{{ url('/address/store') }}" method="POST"
                                          id="add-address-form">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                        <div class="form-group">
                                            <label class="col-sm-4 control-label" for="addresse-input-modal">Full
                                                name</label>

                                            <div class="col-sm-6 form-space-offset">
                                                <input type="text" class="form-control" name="addressee"
                                                       id="addresse-input-modal"
                                                       value="{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}">
                                            </div>
                                        </div>
                                        <br>

                                        <div class="form-group">
                                            <label class="col-sm-4 control-label" for="address_line1-input-modal">
                                                Address Line 1</label>

                                            <div class="col-sm-6 form-space-offset">
                                                <input type="text" class="form-control"
                                                       id="address_line1-input-modal"
                                                       name="address_line1">
                                            </div>
                                        </div>
                                        <br>

                                        <div class="form-group">
                                            <label class="col-sm-4 control-label" for="address_line2-input-modal">
                                                Address line 2</label>

                                            <div class="col-sm-6 form-space-offset">
                                                <input type="text" class="form-control"
                                                       id="address_line2-input-modal"
                                                       name="address_line2">
                                            </div>
                                        </div>
                                        <br>

                                        <div class="form-group">
                                            <label class="col-sm-4 control-label" for="city-input-modal">
                                                City</label>

                                            <div class="col-sm-6 form-space-offset">
                                                <input type="text" class="form-control" name="city"
                                                       id="city-input-modal">
                                            </div>
                                        </div>
                                        <br>

                                        <div class="form-group">
                                            <label class="col-sm-4 control-label" for="state_a2-input-modal">
                                                State</label>

                                            <div class="col-sm-6 form-space-offset">
                                                <input type="text" class="form-control" name="state_a2"
                                                       id="state_a2-input-modal">
                                            </div>
                                        </div>
                                        <br>

                                        <div class="form-group">
                                            <label class="col-sm-4 control-label" for="zip-input-modal">
                                                Zip</label>

                                            <div class="col-sm-6 form-space-offset">
                                                <input type="text" class="form-control" name="zip"
                                                       id="zip-input-modal">
                                            </div>
                                        </div>
                                        <br>

                                        <div class="form-group">
                                            <label class="col-sm-4 control-label"
                                                   for="phone_number-input-modal">Phone</label>

                                            <div class="col-sm-6 form-space-offset">
                                                <input type="tel" class="form-control phone_number"
                                                       id="phone_number-input-modal"
                                                       name="phone_number">
                                            </div>
                                        </div>
                                        <input type="hidden" name="address_id" value="">
                                        <br>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default close-btn"
                                            data-dismiss="modal">
                                        Close
                                    </button>
                                    <i class="fa fa-spinner fa-pulse fa-2x" id="add-loading"></i>
                                    <button id="storeAddedAddress" type="button"
                                            class="btn btn-default primary-btn address-btn form-btn">
                                        Add Address
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Payment method --}}
                <div class="row" id="paymentDiv">
                    @if ($display_payment)
                        <h2>2 Payment method</h2>
                        <div class="row payment-errors-row">
                            <span class="payment-errors"></span>
                        </div>

                        <!-- Nav tabs for payment methods -->
                        <ul class="nav nav-tabs nav-justified" role="tablist">
                            <li role="presentation" class="active"><a href="#credit-card" aria-controls="credit-card"
                                                                      role="tab" data-toggle="tab">Credit Card</a></li>
                            <li role="presentation"><a href="#paypal" aria-controls="paypal" role="tab"
                                                       data-toggle="tab">PayPal</a></li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content payment-method-tabs">
                            <div role="tabpanel" class="tab-pane fade in active" id="credit-card">
                                <div class="payment-card-container">
                                    <div class="row">
                                        <div class="card-wrapper"></div>

                                        <form action="{{ url('/order/store') }}" method="POST" id="form-payment">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="hidden" name="selected_address_id"
                                                   value="{{ $default_address_id }}">
                                            <input type="hidden" name="payment_method" value="credit_card">

                                            <div class="row">
                                                <div class="form-group col-xs-12">
                                                    <input id="payment-number" class="form-control" placeholder="Card number" type="text">
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="form-group col-xs-12">
                                                    <input id="payment-name" class="form-control" placeholder="Full name" type="text">
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="form-group col-xs-4">
                                                    <input id="payment-month" class="form-control" placeholder="MM" type="text" maxlength="2">
                                                </div>

                                                <div class="form-group col-xs-4">
                                                    <input id="payment-year" class="form-control" placeholder="YY" type="text" maxlength="4">
                                                </div>

                                                <div class="form-group col-xs-4">
                                                    <input id="payment-cvc" class="form-control" placeholder="CVC" type="text">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane fade" id="paypal">
                                <div class="paypal-content">
                                    <img class="center-block img-responsive"
                                         src="https://www.paypalobjects.com/webstatic/en_US/i/buttons/PP_logo_h_200x51.png"
                                         alt="PayPal"/>
                                    <hr>
                                    <p class="text-center">
                                        After you place your order, we will redirect you to PayPal website to finish up
                                        the payment.
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Review items --}}
                <div class="row">
                    <h2>3 Review items</h2>

                    <table class="table table-responsive table-default">
                        <thead>
                            <tr>
                                <th>Book</th>
                                <th> </th>
                                <th>ISBN</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        @forelse ($items as $item)
                            <tr>
                                <td>
                                    {{-- Book image --}}
                                    @if($item->product->book->imageSet->small_image)
                                        <img class="img-small"
                                             src="{{ config('aws.url.stuvi-book-img') . $item->product->book->imageSet->small_image }}"
                                             alt="">
                                    @else
                                        <img src="{{ config('book.default_image_path') }}" alt="">
                                    @endif
                                </td>
                                <td>{{ $item->product->book->title }}</td>
                                <td>{{ $item->product->book->isbn10 }}</td>
                                <td>${{ $item->product->decimalPrice() }}</td>
                                @if ($item->product->sold)
                                    <p>Warning: This product has been sold.</p>
                                @endif
                            </tr>
                        @empty
                            <p>You don't have any products in shopping cart.</p>
                        @endforelse
                    </table>
                </div>
            </div>

            {{-- Total Price --}}
            <div class="col-md-4">
                <div class="panel panel-default text-center">
                    <div class="panel-heading">
                        <h3 class="panel-title">Order Summary</h3>
                    </div>
                    <div class="panel-body">
                        <table class="table table-panel">
                            <tbody>
                            <tr>
                                <td class="text-left">Items:</td>
                                <td class="text-right">${{ $subtotal }}</td>
                            </tr>
                            <tr>
                                <td class="text-left">Shipping & handling:</td>
                                <td class="text-right">${{ $shipping }}</td>
                            </tr>
                            <tr>
                                <td class="text-left">Total before tax:</td>
                                <td class="text-right">${{ $subtotal + $shipping }}</td>
                            </tr>
                            <tr>
                                <td class="text-left">Estimated tax to be collected:</td>
                                <td class="text-right">${{ $tax }}</td>
                            </tr>
                            </tbody>
                            <tfoot>
                            <tr>
                                <td class="text-left">Order total:</td>
                                <td class="text-right price">${{ $total }}</td>
                            </tr>
                            </tfoot>
                        </table>
                        <hr>
                        <div>
                            <form action="{{ url('order/store') }}" method="POST" id="form-place-order">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="selected_address_id" value="{{ $default_address_id }}">
                                <input type="hidden" name="payment_method" value="credit_card">

                                <input type="submit" class="btn primary-btn" value="Place your order">
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script src="{{asset('libs-paid/formvalidation-dist-v0.6.3/dist/js/formValidation.min.js')}}"></script>
    <script src="{{asset('libs-paid/formvalidation-dist-v0.6.3/dist/js/framework/bootstrap.min.js')}}"></script>

    <script src="{{ asset('libs/card/lib/js/jquery.card.js') }}"></script>
    <script src="{{ asset('/js/order/buyer/create.js') }}"></script>
@endsection
