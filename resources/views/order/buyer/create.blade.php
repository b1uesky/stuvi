{{-- Checkout page --}}

@extends('layouts.textbook')

@section('title', 'Checkout')

@section('content')

    <div class="container">

        {{-- Breadcrumb --}}
        <div class="row margin-30">
            <nav>
                <ol class="cd-multi-steps text-top">
                    <li class="visited">
                        <a href="{{ url('/cart') }}">Cart</a>
                    </li>
                    <li class="current">
                        <span>Checkout</span>
                    </li>
                    <li>
                        <span>Done</span>
                    </li>
                </ol>
            </nav>
        </div>

        <?php $address = Auth::user()->defaultAddress(); ?>

        <div class="row">
            <div class="col-md-8">
                <div class="container-fluid">
                    {{-- Shipping address --}}
                    <div class="row">

                        @if(!$address)
                            <h3>Enter a new shipping address</h3>

                            <form action="{{ url('address/store') }}" method="post">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                <div class="form-group">
                                    <label for="">Full name</label>
                                    <input type="text" class="form-control" name="addressee">
                                </div>

                                <div class="form-group">
                                    <label for="">Address line 1</label>
                                    <input type="text" class="form-control" name="address_line1">
                                </div>

                                <div class="form-group">
                                    <label for="">Address line 2</label>
                                    <input type="text" class="form-control"
                                           name="address_line2" placeholder="Apartment, suite, unit, building, etc.">
                                </div>

                                <div class="form-group">
                                    <label for="">City</label>
                                    <input type="text" class="form-control" name="city">
                                </div>

                                <div class="form-group">
                                    <label for="">State</label>
                                    <input type="text" class="form-control" name="state_a2">
                                </div>

                                <div class="form-group">
                                    <label for="">ZIP</label>
                                    <input type="text" class="form-control" name="zip">
                                </div>

                                <div class="form-group">
                                    <label for="">Phone number</label>
                                    <input type="text" class="form-control" name="phone_number">
                                </div>

                                <input type="submit" class="btn btn-primary" value="Use this address">
                            </form>
                        @else
                            <h3>Choose a shipping address</h3>

                            <ul class="list-group">

                                @foreach(Auth::user()->addresses as $address)
                                    <li class="list-group-item">
                                        <ul class="no-bullet no-padding-left">
                                            <li>{{ $address->addressee }}</li>
                                            <li>
                                                {{ $address->address_line1 }}
                                                @if($address->address_line2)
                                                    , {{ $address->address_line2 }}
                                                @endif
                                            </li>
                                            <li>{{ $address->city }}, {{ $address->state_a2 }} {{ $address->zip }}</li>
                                            <li>
                                                {{ $address->phone_number }}
                                                <a href="#edit-address" data-toggle="modal"
                                                   data-address_id="{{ $address->id }}"
                                                   data-addressee="{{ $address->addressee }}"
                                                   data-address_line1="{{ $address->address_line1 }}"
                                                   data-address_line2="{{ $address->address_line2 }}"
                                                   data-city="{{ $address->city }}"
                                                   data-state_a2="{{ $address->state_a2 }}"
                                                   data-zip="{{ $address->zip }}"
                                                   data-phone_number="{{ $address->phone_number }}">
                                                    Edit
                                                </a>
                                            </li>
                                            <br>
                                            <li>
                                                @if($address->is_default)
                                                    <button class="btn btn-primary disabled">Selected address</button>
                                                @else
                                                    <form action="{{ url('address/select') }}" method="post" class="no-margin-bottom">
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                        <input type="hidden" name="selected_address_id" value="{{ $address->id }}">
                                                        <input type="submit" class="btn btn-primary" value="Use this address">
                                                    </form>
                                                @endif
                                            </li>
                                        </ul>
                                    </li>
                                @endforeach

                                {{-- Add a new address --}}
                                <li class="list-group-item">
                                    <a href="#add-address" data-toggle="modal">
                                        <span class="glyphicon glyphicon-plus"></span> Add a new address
                                    </a>
                                </li>
                            </ul>
                        @endif
                    </div>

                    {{-- Payment method --}}
                    <div class="row">

                        <h3>Payment method</h3>

                        <div class="radio">
                            <label>
                                <input type="radio" name="payment_method_select" id="payment_method_paypal" value="paypal" checked>
                                <strong>PayPal</strong>
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" name="payment_method_select" id="payment_method_cash" value="cash">
                                <strong>Cash</strong>
                            </label>
                        </div>

                        <small class="text-success">We only collect the payment after delivery.</small>



                            <!-- Nav tabs for payment methods -->
                            {{--<ul class="nav nav-pills" role="tablist">--}}
                            {{--<li role="presentation" class="active"><a href="#credit-card" aria-controls="credit-card"--}}
                            {{--role="tab" data-toggle="tab">Credit Card</a></li>--}}
                            {{--<li role="presentation" class="active"><a href="#paypal" aria-controls="paypal" role="tab"--}}
                            {{--data-toggle="tab">PayPal</a></li>--}}
                            {{--</ul>--}}

                            <!-- Tab panes -->
                            {{--<div class="tab-content">--}}
                                {{--<div role="tabpanel" class="tab-pane fade in active" id="credit-card">--}}
                                {{--<div class="payment-card-container">--}}
                                {{--<div class="row">--}}
                                {{--<div class="card-wrapper"></div>--}}

                                {{--<form action="{{ url('/order/store') }}" method="POST" id="form-payment">--}}
                                {{--<input type="hidden" name="_token" value="{{ csrf_token() }}">--}}
                                {{--<input type="hidden" name="selected_address_id"--}}
                                {{--value="{{ Auth::user()->defaultAddress()->id or '' }}">--}}
                                {{--<input type="hidden" name="payment_method" value="credit_card">--}}

                                {{--<div class="row">--}}
                                {{--<div class="form-group col-xs-12">--}}
                                {{--<input id="payment-number" class="form-control"--}}
                                {{--placeholder="Card number" type="text">--}}
                                {{--</div>--}}
                                {{--</div>--}}

                                {{--<div class="row">--}}
                                {{--<div class="form-group col-xs-12">--}}
                                {{--<input id="payment-name" class="form-control"--}}
                                {{--placeholder="Full name" type="text">--}}
                                {{--</div>--}}
                                {{--</div>--}}

                                {{--<div class="row">--}}
                                {{--<div class="form-group col-xs-4">--}}
                                {{--<input id="payment-month" class="form-control" placeholder="MM"--}}
                                {{--type="text" maxlength="2">--}}
                                {{--</div>--}}

                                {{--<div class="form-group col-xs-4">--}}
                                {{--<input id="payment-year" class="form-control" placeholder="YY"--}}
                                {{--type="text" maxlength="4">--}}
                                {{--</div>--}}

                                {{--<div class="form-group col-xs-4">--}}
                                {{--<input id="payment-cvc" class="form-control" placeholder="CVC"--}}
                                {{--type="text">--}}
                                {{--</div>--}}
                                {{--</div>--}}
                                {{--</form>--}}
                                {{--</div>--}}
                                {{--</div>--}}
                                {{--</div>--}}
                                {{--<div role="tabpanel" class="tab-pane fade in active" id="paypal">--}}
                                    {{--<div class="paypal-content">--}}
                                        {{--<img class="center-block img-responsive"--}}
                                             {{--src="https://www.paypalobjects.com/webstatic/en_US/i/buttons/PP_logo_h_200x51.png"--}}
                                             {{--alt="PayPal"/>--}}
                                        {{--<hr>--}}
                                        {{--<p class="text-center">--}}
                                            {{--After placing your order, we will redirect you to PayPal website to finish up--}}
                                            {{--the payment.--}}
                                        {{--</p>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                    </div>

                    {{-- Review items --}}
                    <div class="row">
                        <h3>Review items</h3>

                        <table class="table">
                            <thead>
                            <tr>
                                <th>Book</th>
                                <th></th>
                                <th class="hidden-xs">ISBN-10</th>
                                <th>Price</th>
                            </tr>
                            </thead>

                            @forelse ($items as $item)
                                <tr>
                                    <td>
                                        {{-- Book image --}}
                                        <img class="img-responsive" src="{{ $item->product->book->imageSet->getImagePath('small') }}" alt="">
                                    </td>
                                    <td>{{ $item->product->book->title }}</td>
                                    <td class="hidden-xs">{{ $item->product->book->isbn10 }}</td>
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
            </div>

            {{-- Total Price --}}
            <div class="col-md-4">
                <div class="panel panel-default text-center">
                    <div class="panel-heading">
                        <h2 class="panel-title">Order Summary</h2>
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
                            @if($discount > 0)
                                <tr>
                                    <td class="text-left">Discount:</td>
                                    <td class="text-right">- ${{ $discount }}</td>
                                </tr>
                            @endif
                            <tr>
                                <td class="text-left">Total before tax:</td>
                                <td class="text-right">${{ $subtotal + $shipping - $discount }}</td>
                            </tr>
                            <tr>
                                <td class="text-left">Estimated tax:</td>
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
                        <div>
                            <form action="{{ url('order/store') }}" method="POST" id="form-place-order">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="payment_method" value="paypal">

                                @if(Auth::user()->defaultAddress())
                                    <input type="hidden" name="selected_address_id" value="{{ Auth::user()->defaultAddress()->id }}">
                                    <input type="submit" class="btn btn-primary" value="Place your order">
                                @else
                                    <input type="hidden" name="selected_address_id">
                                    <input type="submit" class="btn btn-primary disabled" value="Place your order">
                                @endif
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@include('includes.modal.add-address')
@include('includes.modal.edit-address')