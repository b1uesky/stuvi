@extends('layouts.textbook')

@section('title', 'Schedule a pickup')

@section('css')
    <link rel="stylesheet"
          href="{{ asset('libs/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css') }}"/>
@endsection

@section('content')

    <div class="container">

        <div class="row">
            <div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">

                <?php $address = $seller_order->seller()->defaultAddress(); ?>

                {{--{{dd($address)}}--}}

                @if(!$address)
                    <h3>Enter a new pickup address</h3>

                    <hr>

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
                    <h3>Choose a pickup address</h3>

                    <hr>

                    <ul class="list-group">

                        @foreach($seller_order->seller()->addresses as $address)
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
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add-address">
                                Add a new address
                            </button>
                        </li>
                    </ul>
                @endif

                <h3>Choose a pickup time</h3>

                <hr>

                <div id="datetimepicker"></div>

                    <br>


                <form action="{{ url('/order/seller/' . $seller_order->id . '/confirmPickup') }}" method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="address_id" value="{{ $seller_order->seller()->defaultAddress()->id or '' }}">
                    <input type="hidden" name="scheduled_pickup_time" value="{{ date(config('app.datetime_format'), strtotime($seller_order->scheduled_pickup_time)) }}">

                    <input type="submit" class="btn btn-primary" value="Update pickup details">
                </form>

                    <br>
            </div>
        </div>


    </div>
@endsection

@include('includes.modal.add-address')
@include('includes.modal.edit-address')

@section('javascript')
    <script src="{{ asset('libs/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('libs/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{ asset('js/order/seller/schedulePickup.js') }}"></script>
@endsection