{{-- Checkout page
--  For stripe API: https://stripe.com/docs/stripe.js
                --}}

@extends('app')

@section('title', 'Checkout')

@section('css')
    <link href="{{ asset('/css/order_buyer_create.css') }}" rel="stylesheet">
@endsection

@section('content')

    @if (Session::has('message'))
        <div class="container" id="message-cont" xmlns="http://www.w3.org/1999/html">
            <div class="flash-message" id="message"><i
                        class="fa fa-exclamation-triangle"></i> {{ Session::get('message') }}</div>
        </div>
    @endif

    <div class="row back-row">
        <a id="back-to-cart" href="{{ url('/cart') }}"><i class="fa fa-arrow-circle-left"></i>Back to Cart</a>
    </div>
    <div class="container col-xs-12 col-xs-offset-2 col-sm-8 col-sm-offset-2 cart-progress">
        <img class="img-responsive cart-line col-sm-offset-3" src="{{asset('/img/CHECKOUT.png')}}"
             alt="Your cart progress">
    </div>
    <div class="container">
        <h1 id="checkout-title">Checkout Books</h1>

        <div class="row">
            <div class="col-md-10 col-md-offset-1">
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


                    <h2>1. Confirm order items</h2></br>

                    <table class="table table-striped table-responsive cart-table">
                        <tr>
                            <th>Book Title</th>
                            <th>ISBN</th>
                            <th>Price</th>
                        </tr>

                        @forelse ($items as $item)
                            <tr>
                                <td>{{ $item->product->book->title }}</td>
                                <td>{{ $item->product->book->isbn10 }}</td>
                                <td>${{ $item->product->price }}</td>
                                @if ($item->product->sold)
                                    <p>Warning: This product has been sold.</p>
                                @endif
                            </tr>
                        @empty
                            <p>You don't have any products in shopping cart.</p>
                        @endforelse
                    </table>
                    <h2>2. Shipping address</h2></br>
                    <div class="address row">
                        @forelse ($addresses as $address)
                            @if ($address -> is_default)
                                <div class="col-sm-4 panel address-panel displayDefaultAddress">
                                    <div class="panel-body">
                                        <ul class="address-list">
                                            <li class="address" id="default_addressee">{{ $address -> addressee }}</li>
                                            <li class="address"
                                                id="default_address_line1">{{ $address -> address_line1}}</li>
                                            @if($address -> address_line2 != null)
                                                <li class="address"
                                                    id="default_address_line2">{{ $address -> address_line2}}</li>
                                            @endif
                                            {{--<li class="address" id="default_city">{{ $address -> city }}--}}
                                            {{--, {{ $address -> state_a2 }} {{ $address -> zip }}</li>--}}
                                            <li class="address inline" id="default_city">{{ $address -> city }},</li>
                                            <li class="address inline"
                                                id="default_state_a2">{{ $address -> state_a2 }}</li>
                                            <li class="address inline" id="default_zip">{{ $address -> zip }}</li>
                                            <li class="address" id="default_phone">{{ $address -> phone_number }}</li>
                                        </ul>
                                        <button class="btn btn-default primary-btn address-btn show-addresses">
                                            <i class="fa fa-pencil"></i>
                                            Change Address
                                        </button>
                                    </div>
                                </div>
                            @endif
                            <div class="panel address-panel col-md-4 displayAllAddresses {{ $address -> id }}">
                                <div class="panel-body">
                                    <ul class="address-list">
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
                                    <button class="btn btn-default primary-btn address-btn selectThisAddress">
                                        <i class="fa fa-check-square"></i>
                                        Select
                                    </button>
                                    <button class="btn btn-default primary-btn address-btn editThisAddress"
                                            data-toggle="modal"
                                            data-target="#update-address-modal">
                                        <i class="fa fa-pencil"></i>
                                        Edit
                                    </button>
                                    <button class="btn btn-default primary-btn address-btn deleteThisAddress">
                                        <i class="fa fa-trash"></i>
                                        Delete
                                    </button>
                                </div>
                            </div>
                        @empty
                            <form action="{{ url('/address/store') }}" method="POST"
                                  class="address-form">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Full name</label>

                                    <div class="col-sm-6 form-space-offset">
                                        <input type="text" class="form-control" name="addressee"
                                               value="{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}">
                                    </div>
                                </div>
                                </br>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Address line 1</label>

                                    <div class="col-sm-6 form-space-offset">
                                        <input type="text" class="form-control" name="address_line1"
                                               value="185 Freeman St.">
                                    </div>
                                </div>
                                </br>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Address line 2</label>

                                    <div class="col-sm-6 form-space-offset">
                                        <input type="text" class="form-control" name="address_line2"
                                               value="Apt. 739">
                                    </div>
                                </div>
                                </br>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">City</label>

                                    <div class="col-sm-6 form-space-offset">
                                        <input type="text" class="form-control" name="city"
                                               value="Brookline">
                                    </div>
                                </div>
                                </br>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">State</label>

                                    <div class="col-sm-6 form-space-offset">
                                        <input type="text" class="form-control" name="state_a2" value="MA">
                                    </div>
                                </div>
                                </br>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Zip</label>

                                    <div class="col-sm-6 form-space-offset">
                                        <input type="text" class="form-control" name="zip" value="02446">
                                    </div>
                                </div>
                                </br>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Phone</label>

                                    <div class="col-sm-6 form-space-offset">
                                        <input type="tel" class="form-control phone_number"
                                               name="phone_number" value="(857) 206 4789">
                                    </div>
                                </div>
                                </br>
                                <button class="btn btn-default primary-btn address-btn" id="storeAddress"
                                        type="submit">
                                    Add Address
                                </button>
                            </form>
                        @endforelse
                        <div id="new-address-panel" class="col-sm-5 panel address-panel">
                            <div class="panel-body">
                                <h4>Add New Address</h4>
                                <i class="fa fa-plus-square fa-4x"
                                   data-toggle="modal" data-target="#add-address-modal">
                                </i>
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
                                              class="update-address-form">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="hidden" name="address_id" value="">

                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">Full name</label>

                                                <div class="col-sm-6 form-space-offset">
                                                    <input type="text" class="form-control" name="addressee"
                                                           value="{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}">
                                                </div>
                                            </div>
                                            </br>
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">Address line 1</label>

                                                <div class="col-sm-6 form-space-offset">
                                                    <input type="text" class="form-control"
                                                           name="address_line1"
                                                           value="185 Freeman St.">
                                                </div>
                                            </div>
                                            </br>
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">Address line 2</label>

                                                <div class="col-sm-6 form-space-offset">
                                                    <input type="text" class="form-control"
                                                           name="address_line2"
                                                           value="Apt. 739">
                                                </div>
                                            </div>
                                            </br>
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">City</label>

                                                <div class="col-sm-6 form-space-offset">
                                                    <input type="text" class="form-control" name="city"
                                                           value="Brookline">
                                                </div>
                                            </div>
                                            </br>
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">State</label>

                                                <div class="col-sm-6 form-space-offset">
                                                    <input type="text" class="form-control" name="state_a2"
                                                           value="MA">
                                                </div>
                                            </div>
                                            </br>
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">Zip</label>

                                                <div class="col-sm-6 form-space-offset">
                                                    <input type="text" class="form-control" name="zip"
                                                           value="02446">
                                                </div>
                                            </div>
                                            </br>
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">Phone</label>

                                                <div class="col-sm-6 form-space-offset">
                                                    <input type="tel" class="form-control phone_number"
                                                           name="phone_number" value="(857) 206 4789">
                                                </div>
                                            </div>
                                            <input type="hidden" name="address_id" value="">
                                            </br>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default close-btn" data-dismiss="modal">
                                            Close
                                        </button>
                                        <button id="storeUpdatedAddress" type="button"
                                                class="btn btn-default primary-btn address-btn">
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
                                              class="add-address-form">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">Full name</label>

                                                <div class="col-sm-6 form-space-offset">
                                                    <input type="text" class="form-control" name="addressee"
                                                           value="{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}">
                                                </div>
                                            </div>
                                            </br>
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">Address line 1</label>

                                                <div class="col-sm-6 form-space-offset">
                                                    <input type="text" class="form-control"
                                                           name="address_line1"
                                                           value="185 Freeman St.">
                                                </div>
                                            </div>
                                            </br>
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">Address line 2</label>

                                                <div class="col-sm-6 form-space-offset">
                                                    <input type="text" class="form-control"
                                                           name="address_line2"
                                                           value="Apt. 739">
                                                </div>
                                            </div>
                                            </br>
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">City</label>

                                                <div class="col-sm-6 form-space-offset">
                                                    <input type="text" class="form-control" name="city"
                                                           value="Brookline">
                                                </div>
                                            </div>
                                            </br>
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">State</label>

                                                <div class="col-sm-6 form-space-offset">
                                                    <input type="text" class="form-control" name="state_a2"
                                                           value="MA">
                                                </div>
                                            </div>
                                            </br>
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">Zip</label>

                                                <div class="col-sm-6 form-space-offset">
                                                    <input type="text" class="form-control" name="zip"
                                                           value="02446">
                                                </div>
                                            </div>
                                            </br>
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label">Phone</label>

                                                <div class="col-sm-6 form-space-offset">
                                                    <input type="tel" class="form-control phone_number"
                                                           name="phone_number" value="(857) 206 4789">
                                                </div>
                                            </div>
                                            <input type="hidden" name="address_id" value="">
                                            </br>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default close-btn"
                                                data-dismiss="modal">
                                            Close
                                        </button>
                                        <button id="storeAddedAddress" type="button"
                                                class="btn btn-default primary-btn address-btn">
                                            Add Address
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- payment form here -->
                    <!-- begin stripe form -->
                    @if ($display_payment)
                        <h2>3. Payment</h2>

                        <div class="stripe-container">
                            <div class="card-wrapper"></div>

                            <form action="{{ url('/order/store') }}" method="POST" id="form-payment">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="selected_address_id" value="{{$default_address_id}}">
                                <input type="hidden" name="stripe_public_key" value="{{ $stripe_public_key }}">
                                <input type="hidden" name="stripe_token" value="" />

                                <div class="row">
                                    <div class="form-group col-xs-12">
                                        <input id="stripe-number" class="form-control input-lg" placeholder="Card number" type="text" data-stripe="number">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-xs-4">
                                        <input id="stripe-month" class="form-control input-lg" placeholder="MM" type="text" data-stripe="exp-month">
                                    </div>

                                    <div class="form-group col-xs-4">
                                        <input id="stripe-year" class="form-control input-lg" placeholder="YY" type="text" data-stripe="exp-year">
                                    </div>

                                    <div class="form-group col-xs-4">
                                        <input id="stripe-cvc" class="form-control input-lg" placeholder="CVC" type="text" data-stripe="cvc">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xs-12">
                                        <input class="btn btn-lg primary-btn btn-block" type="submit" value="Confirm">
                                    </div>
                                </div>

                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script src="{{asset('libs-paid/formvalidation-dist-v0.6.3/dist/js/formValidation.min.js')}}"></script>
    <script src="{{asset('libs-paid/formvalidation-dist-v0.6.3/dist/js/framework/bootstrap.min.js')}}"></script>

    <script src="{{ asset('libs/card/lib/js/jquery.card.js') }}"></script>
    <script src="https://js.stripe.com/v2/"></script>
    <script src="{{ asset('/js/order-create.js') }}"></script>
@endsection