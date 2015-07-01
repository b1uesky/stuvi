{{-- Your orders page --}}


@extends('app')

@section('content')

    <head>
        <link href="{{ asset('/css/order/showOrder.css') }}" rel="stylesheet" type="text/css">
        {{-- date time picker required--}}
        <link rel="stylesheet" type="text/css" href="{{asset('/datetimepicker/jquery.datetimepicker.css')}}"/>
        <title>Stuvi - Order Details</title>


        <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
        <!-- jQuery is used only for this example; it isn't required to use Stripe -->
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

        <script type="text/javascript">
            // This identifies your website in the createToken call below
            Stripe.setPublishableKey("{{ \App::environment('production') ? Config::get('stripe.live_public_key') : Config::get('stripe.test_public_key') }}");

            var stripeResponseHandler = function(status, response) {
                var $form = $('#payment-form');

                if (response.error) {
                    // Show the errors on the form
                    $form.find('.payment-errors').text(response.error.message);
                    $form.find('button').prop('disabled', false);
                } else {
                    // token contains id, last4, and card type
                    var token = response.id;
                    // Insert the token into the form so it gets submitted to the server
                    $form.append($('<input type="hidden" name="stripeToken" />').val(token));
                    // and re-submit
                    $form.get(0).submit();
                }
            };

            jQuery(function($) {
                $('#payment-form').submit(function(event) {

                    var $form = $(this);

                    // Disable the submit button to prevent repeated clicks
                    $form.find('button').prop('disabled', true);

                    Stripe.card.createToken($form, stripeResponseHandler);

                    // Prevent the form from submitting with the default action
                    return false;
                });
            });

        </script>


    </head>

    <!-- print button -->
    <div class="print"><a href="" onclick="printWindow()"><i class="fa fa-print"></i> Print Invoice
        </a>
    </div>

    <div class="container show-order-container">
        <!-- order details -->
        <div class="container cont-1">
            <h1 id="h1-showBuy">Order Details</h1>
        </div>

        <!-- ordered on, order # -->
        <div class="row" id="details1">
            <p class="col-xs-12 col-sm-4 col-sm-offset-0">Ordered on {{ $seller_order->created_at }}</p>
            <p class="col-xs-12 col-sm-4">Order #{{ $seller_order->id }}</p>
        </div>

        {{-- Order has been picked up --}}
        @if($seller_order->pickedUp())
            <div class="alert alert-success">The textbook has been picked up by our courier.</div>
        @elseif(!$seller_order->cancelled)
            <p><a class="btn btn-default btn-cancel" href="/order/seller/cancel/{{ $seller_order->id }}">Cancel Order</a></p>
        @else
            <div class="alert alert-danger">This order has been cancelled.</div>
        @endif

        @if ($seller_order->isDelivered())
            <!-- Get order money back to seller debit card -->
            <form action="{{ url('/order/seller/transfer') }}" method="POST">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="seller_order_id" value="{{ $seller_order->id }}">
                <button type="submit" class="btn btn-primary">Get money back</button>
            </form>
        @endif

        {{-- Messages --}}
        <div class="container" xmlns="http://www.w3.org/1999/html">
            @if (Session::has('message'))
                <div class="flash-message">{{ Session::get('message') }}</div>
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
            @if(Session::has('success'))
                <div class="alert alert-success">{{ Session::get('success') }}</div>
            @endif
        </div>

        <!-- items in order -->
        <div class="container" id="details3">
            <div class="row row-items">
                <h3 class="col-xs-12">Item</h3>
            </div>
            <!-- item info -->
            <div class="item col-xs-12 col-sm-6">
                <?php $product = $seller_order->product; $book = $product->book; ?>
                    <p>Title: <a href="{{ url('/textbook/buy/product/'.$product->id) }}">{{ $book->title }}</a></p>
                    <p>ISBN: {{ $book->isbn10 }}</p>
                    <p>Price: ${{ $product->price }}</p>
                    @if($seller_order->scheduled())
                        <p>Scheduled Pickup Time: {{ date($datetime_format, strtotime($seller_order->scheduled_pickup_time)) }}</p>
                    @endif
            </div>

            {{-- If the order is not cancelled and not picked up --}}
            @if(!$seller_order->cancelled && !$seller_order->pickedUp())
                {{-- Schedule pickup time --}}
                <div class="row">
                    <div class="col-xs-12 col-sm-6">
                        <form action="{{ url('/order/seller/setscheduledtime') }}" method="POST">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="id" value="{{ $seller_order->id }}">
                            <div class="form-group">
                                <label for="datetimepicker">Schedule a pickup time</label>
                                <input class="form-control" id="datetimepicker" class="input-append date" type="text" name="scheduled_pickup_time">
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <!-- scheduled already and not cancelled. allows for reschedule -->
                                @if($seller_order->scheduled() && !$seller_order->cancelled)
                                    Reschedule
                                @else
                                    Schedule
                                @endif
                            </button>
                        </form>
                    </div>
                </div>  <!-- end pick up row -->

                {{-- TODO: Add New Address --}}
                {{-- TODO: Save New Address --}}
                {{-- TODO: Choose Address --}}
            @endif
        </div>
    </div>

            <!-- Date time picker required scripts -->
    <script src="{{asset('datetimepicker/jquery.js')}}"></script>
    <script src="{{asset('datetimepicker/jquery.datetimepicker.js')}}"></script>
    <script src="{{asset('/js/showOrder.js')}}" type="text/javascript"></script>


@endsection