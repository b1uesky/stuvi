@extends('layouts.textbook')

@section('title', 'Schedule a pickup')

@section('css')
    <link rel="stylesheet"
          href="{{ asset('libs/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css') }}"/>
@endsection

@section('content')

    <div class="container page-content">

        <div class="row">
            <div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
                {{--select address --}}
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Pickup details</h3>
                    </div>

                    <div class="panel-body">
                        <?php $address = $seller_order->address ?: $seller_order->seller()->defaultAddress(); ?>
                        <div class="container-fluid">
                            <form action="{{ url('/order/seller/' . $seller_order->id . '/confirmPickup') }}" method="post">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                <div class="form-group">
                                    <label for="">Pickup time</label>
                                    <input type="text" class="form-control" id="datetimepicker" value="{{ date(config('app.datetime_format'), strtotime($seller_order->scheduled_pickup_time)) }}" name="scheduled_pickup_time">
                                </div>

                                <div class="form-group">
                                    <label for="">Full name</label>
                                    <input type="text" class="form-control" value="{{ $address->addressee }}" name="addressee">
                                </div>

                                <div class="form-group">
                                    <label for="">Address line 1</label>
                                    <input type="text" class="form-control" value="{{ $address->address_line1 }}" name="address_line1">
                                </div>

                                <div class="form-group">
                                    <label for="">Address line 2
                                        <small class="text-muted">Apartment, suite, unit, building, floor, etc.</small>
                                    </label>
                                    <input type="text" class="form-control" value="{{ $address->address_line2 }}" name="address_line2">
                                </div>

                                <div class="form-group">
                                    <label for="">City</label>
                                    <input type="text" class="form-control" value="{{ $address->city }}" name="city">
                                </div>

                                <div class="form-group">
                                    <label for="">State</label>
                                    <input type="text" class="form-control" value="{{ $address->state_a2 }}" name="state_a2">
                                </div>

                                <div class="form-group">
                                    <label for="">ZIP</label>
                                    <input type="text" class="form-control" value="{{ $address->zip }}" name="zip">
                                </div>

                                <div class="form-group">
                                    <label for="">Phone number</label>
                                    <input type="text" class="form-control" value="{{ $address->phone_number }}" name="phone_number">
                                </div>

                                <input type="submit" class="btn btn-primary" value="Update">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
@endsection

@section('javascript')
    <script src="{{ asset('libs/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('libs/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{ asset('js/order/seller/schedulePickup.js') }}"></script>
@endsection