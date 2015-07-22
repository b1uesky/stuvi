{{-- Your orders page --}}


@extends('app')

@section('title', 'Order details - Order #'.$seller_order->id)

@section('css')
    <link href="{{ asset('/css/order_show.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{asset('/js/datetimepicker/jquery.datetimepicker.css')}}"/>
@endsection

@section('content')

    <div class="container show-order-container">
        <!-- order details -->
        <div class="container cont-1">
            <h1 id="h1-showBuy">Order Details</h1>
        </div>

        <!-- ordered on, order # -->
        <div class="row" id="details1">
            <p class="col-xs-12 col-sm-4 col-sm-offset-0">Sold on {{ $seller_order->created_at }}</p>

            <p class="col-xs-12 col-sm-4">Order #{{ $seller_order->id }}</p>
        </div>

        <div class="alert-container">
            @if ($seller_order->isTransferred())
                <div class="alert alert-success">The balance of this order is transferred to your Stripe account.</div>
            @elseif ($seller_order->isDelivered())
                @if ($seller_order->seller()->stripeAuthorizationCredential()->get()->isEmpty()))
                <a href="#">Link Stripe account to get money back</a>
                @else
                        <!-- Get order money back to seller debit card -->
                <form action="{{ url('/order/seller/transfer') }}" method="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="seller_order_id" value="{{ $seller_order->id }}">
                    <button type="submit" class="btn btn-primary">Get money back</button>
                </form>
                @endif
            @elseif ($seller_order->pickedUp())
                <div class="alert alert-success">The textbook has been picked up by our courier. You can get your money
                    back once the textbook is delivered.
                </div>
            @elseif ($seller_order->cancelled)
                <div class="alert alert-danger">This order has been cancelled.</div>
            @else
                <p><a class="btn btn-default btn-cancel" href="/order/seller/cancel/{{ $seller_order->id }}">Cancel
                        Order</a></p>
            @endif
        </div>

        {{-- Messages --}}
        <div class="container" id="message-cont" xmlns="http://www.w3.org/1999/html">
            @if (Session::has('message'))
                <div class="flash-message" id="message">{{ Session::get('message') }}</div>
            @endif

            {{-- Errors for invalid data --}}
            @if ($errors->has())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        {{ $error }}<br>
                    @endforeach
                </div>
            @endif

            {{-- Successfully scheduled a pickup time --}}
            <div class="alert-success-container">
                @if(Session::has('success'))
                    <div class="alert alert-success">{{ Session::get('success') }}</div>
                @endif
            </div>

            {{-- Confirm pickup error --}}
            @if(Session::has('confirm_pickup_errors'))
                <div class="alert alert-danger">
                    @foreach(Session::get('confirm_pickup_errors') as $index => $error)
                        {{ $error }}<br>
                    @endforeach
                </div>
            @endif

        </div>

        <!-- items in order -->
        <div class="container box" id="details3">
            <div class="row row-title">
                <h3 class="col-xs-12">Item</h3>
            </div>
            <!-- item info -->
            <div class="item col-xs-12 col-sm-6">
                <?php $product = $seller_order->product; $book = $product->book; ?>
                <p>Title: <a href="{{ url('/textbook/buy/product/'.$product->id) }}">{{ $book->title }}</a></p>

                <p>ISBN: {{ $book->isbn10 }}</p>

                <p>Price: ${{ $product->price }}</p>
            </div>
        </div>

        <div class="container box">
            {{-- If the order is not cancelled and not picked up --}}
            @if(!$seller_order->cancelled && !$seller_order->pickedUp())

                {{-- Schedule pickup time --}}
                <div class="row row-title">
                    <h3 class="col-xs-12">Schedule a pickup time</h3>
                </div>

                <div class="text-scheduled-pickup-time">
                    @if($seller_order->scheduledPickupTime())
                        Scheduled pickup
                        time: {{ date($datetime_format, strtotime($seller_order->scheduled_pickup_time)) }}
                    @else
                        {{-- Nothing --}}
                    @endif
                </div><br>

                <form action="{{ url('/order/seller/setscheduledtime') }}" method="POST" id="schedule-pickup-time">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" id="schedule-token">
                    <input type="hidden" name="seller_order_id" value="{{ $seller_order->id }}">

                    <div class="form-inline">
                        <div class="form-group">
                            <label class="sr-only" for="datetimepicker">Date and Time</label>

                            <div class="input-group">
                                <div class="input-group-addon" id="cal-icon" onclick="setFocusToTextBox()"><i
                                            class="fa fa-calendar"></i></div>
                                <input class="form-control" id="datetimepicker" class="input-append date" type="text"
                                       name="scheduled_pickup_time">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-orange">
                            <!-- scheduled already and not cancelled. allows for reschedule -->
                            @if($seller_order->scheduledPickupTime() && !$seller_order->cancelled)
                                Reschedule
                            @else
                                Schedule
                            @endif
                        </button>
                    </div>

                    <br><br>

                </form>
        </div>
        <div class="container box">
            {{-- Select pickup address --}}
            <div class="row row-title">
                <h3 class="col-xs-12">Select a pickup address</h3>
            </div>

            <?php $address = $seller_order->seller()->defaultAddress(); ?>

            {{-- If the seller has a default address --}}
            @if($address)
                <div class="seller-address-box">
                    <div>
                        <button type="button" class="btn btn-default btn-change-address">Change</button>
                    </div>

                    <div class="seller-address">
                        <ul>
                            {{-- WARNING: if you need to change class names below,
                            make sure you change the selectors in updateDefaultAddress() in `showSellerOrder.js`. --}}
                            <li class="seller-address-addressee">{{ $address->addressee }}</li>
                            <li class="seller-address-address-line">
                                @if($address->address_line2)
                                    {{ $address->address_line1 }}, {{ $address->address_line2 }}
                                @else
                                    {{ $address->address_line1 }}
                                @endif
                            </li>
                            <li>
                                <span class="seller-address-city">{{ $address->city }}, </span>
                                <span class="seller-address-state">{{ $address->state_a2 }} </span>
                                <span class="seller-address-zip">{{ $address->zip }}</span>
                            </li>
                        </ul>
                    </div>

                    {{-- Invisible by default. Show after click the change button. --}}
                    <div class="seller-address-book">
                        @foreach($seller_order->seller()->addresses as $address)
                            <div>
                                <ul>
                                    <li>{{ $address->addressee }}</li>
                                    <li>
                                        @if($address->address_line2)
                                            {{ $address->address_line1 }}, {{ $address->address_line2 }}
                                        @else
                                            {{ $address->address_line1 }}
                                        @endif
                                    </li>
                                    <li>
                                        <span>{{ $address->city }}, </span>
                                        <span>{{ $address->state_a2 }} </span>
                                        <span>{{ $address->zip }}</span>
                                    </li>
                                    <li>{{ $address->country_name }}</li>
                                    <li>Phone: {{ $address->phone_number }}</li>
                                </ul>

                                {{-- Ajax: select default address --}}
                                <form action="" method="post" class="form-update-default-address">
                                    <input type="hidden" name="address_id" value="{{ $address->id }}"/>
                                    <input type="submit" name="submit" value="Select" class="btn btn-default"/>
                                </form>

                                {{-- TODO: Edit address --}}
                                <form action="" method="get" class="form-edit-address">
                                    <input type="hidden" name="address_id" value="{{ $address->id }}"/>
                                    <input type="submit" name="submit" value="Edit" class="btn btn-default"/>
                                </form>

                            </div>

                        @endforeach

                        {{-- Add a new address --}}
                        <div>
                            <a href="{{ url('order/seller/' . $seller_order->id . '/addAddress') }}"
                               class="btn btn-orange">Add a new address</a></br></br>
                        </div>
                    </div>
                </div>
            @else
                {{-- Add a new address --}}
                <div>
                    <a href="{{ url('order/seller/' . $seller_order->id . '/addAddress') }}"
                       class="btn btn-orange">Add a new address</a></br></br>
                </div>
            @endif
        </div>
        {{-- Confirm pickup --}}
        <a href="{{ url('/order/seller/' . $seller_order->id . '/confirmPickup') }}" class="btn btn-primary">Confirm
            Pickup</a></br></br>
        @endif
    </div>
@endsection

@section('javascript')
    {{--http://xdsoft.net/jqplugins/datetimepicker/--}}
    <!-- Date time picker required scripts -->
    <script src="{{asset('/js/datetimepicker/jquery.js')}}"></script>
    <script src="{{asset('/js/datetimepicker/jquery.datetimepicker.js')}}"></script>

    <script src="{{asset('/js/order/seller/showSellerOrder.js')}}" type="text/javascript"></script>
@endsection