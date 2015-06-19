@extends('app')

{{--<link href="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/css/bootstrap-combined.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" media="screen"
      href="http://tarruda.github.com/bootstrap-datetimepicker/assets/css/bootstrap-datetimepicker.min.css"> --}}


@section('content')

    <head>
        <link href="{{ asset('/css/showOrder.css') }}" rel="stylesheet" type="text/css">

        <title>Stuvi - Order Details</title>
    </head>

    <!-- print button -->
    <div class="print"><a href="" onclick="printWindow()"><i class="fa fa-print"></i> Print Invoice
        </a>
    </div>

    <div class="container">
        <!-- message -->
        <div class="container" xmlns="http://www.w3.org/1999/html">
            @if (Session::has('message'))
                <div class="flash-message">{{ Session::get('message') }}</div>
            @endif
        </div>

        <!-- order details -->
        <div class="container cont-1">
            <h1 id="h1-showBuy">Order Details</h1>
            <h2>@if ($seller_order->cancelled)
                    <span id="cancelled">This order has been cancelled.</span>@endif
            </h2>
        </div>

        <!-- ordered on, order # -->
        <div class="row" id="details1">
            <p class="col-xs-12 col-sm-4 col-sm-offset-0">Ordered on {{ $seller_order->created_at }}</p>
            <p class="col-xs-12 col-sm-4">Order #{{ $seller_order->id }}</p>
        </div>
        @if (!$seller_order->cancelled)
            <p><a class="btn btn-default btn-cancel" href="/order/seller/cancel/{{ $seller_order->id }}">Cancel Order</a></p>
            @endif

        <!-- items in order -->
        <div class="container" id="details3">
            <div class="row row-items">
                <h3 class="col-xs-12">Items</h3>
            </div>
            <!-- item info -->
            <div class="item col-xs-12 col-sm-6">
                <?php $product = $seller_order->product; $book = $product->book; ?>
{{--                <p><label class="col-md-4 control-label">Title: {{ $book->title }}</label></p>
                <p><label class="col-md-4 control-label">ISBN: {{ $book->isbn }}</label></p>
                <p><label class="col-md-4 control-label">Price: {{ $product->price }}</label></p>--}}
                    <p>Title: {{ $book->title }}</p>
                    <p>ISBN: {{ $book->isbn }}</p>
                    <p>Price: ${{ $product->price }}</p>
            </div>
            <!-- pick up form-->
            <div class="row">
                <div class="col-xs-12 col-sm-6">
                    <p>{{--label class="col-md-8 control-label">Scheduled pick-up time:</label>--}}
                     Schedule a pick-up time </p>


{{--                    @if ($seller_order->scheduled_pickup_time)
                        {{ date($datetime_format, strtotime($seller_order->scheduled_pickup_time)) }}
                        <form action="{{ url('/order/seller/setscheduledtime') }}" method="POST">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="id" value="{{ $seller_order->id }}">

                            <div class="form-group col-md-8">
                                <div id="datetimepicker" class="input-append date">
                                    <input class="input-box" type="text" name="scheduled_pickup_time"></input>
                          <span class="add-on">
                            <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
                              --}}{{--<i class="fa fa-calendar"></i>--}}{{--
                          </span>
                                    <button type="submit" class="btn btn-primary">Set</button>
                                </div>
                                <script type="text/javascript"
                                        src="http://cdnjs.cloudflare.com/ajax/libs/jquery/1.8.3/jquery.min.js">
                                </script>
                                <script type="text/javascript"
                                        src="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/js/bootstrap.min.js">
                                </script>
                                <script type="text/javascript"
                                        src="http://tarruda.github.com/bootstrap-datetimepicker/assets/js/bootstrap-datetimepicker.min.js">
                                </script>
                                <script type="text/javascript"
                                        src="http://tarruda.github.com/bootstrap-datetimepicker/assets/js/bootstrap-datetimepicker.pt-BR.js">
                                </script>
                                <script type="text/javascript">
                                    $('#datetimepicker').datetimepicker({
                                        format: 'dd/MM/yyyy hh:mm',
                                        language: 'us-EN'
                                    });
                                </script>

                            </div>
                        </form>
                    @elseif (!$seller_order->cancelled)
                    <form action="{{ url('/order/seller/setscheduledtime') }}" method="POST">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="id" value="{{ $seller_order->id }}">

                        <div class="form-group col-md-8">
                        <div id="datetimepicker" class="input-append date">
                            <input class="input-box" type="text" name="scheduled_pickup_time"></input>
                          <span class="add-on">
                            <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
                              --}}{{--<i class="fa fa-calendar"></i>--}}{{--
                          </span>
                            <button type="submit" class="btn btn-primary">Set</button>
                        </div>
                       <script type="text/javascript"
                                src="http://cdnjs.cloudflare.com/ajax/libs/jquery/1.8.3/jquery.min.js">
                        </script>
                        <script type="text/javascript"
                                src="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/js/bootstrap.min.js">
                        </script>
                        <script type="text/javascript"
                                src="http://tarruda.github.com/bootstrap-datetimepicker/assets/js/bootstrap-datetimepicker.min.js">
                        </script>
                        <script type="text/javascript"
                                src="http://tarruda.github.com/bootstrap-datetimepicker/assets/js/bootstrap-datetimepicker.pt-BR.js">
                        </script>
                        <script type="text/javascript">
                            $('#datetimepicker').datetimepicker({
                                format: 'dd/MM/yyyy hh:mm',
                                language: 'us-EN'
                            });
                        </script>

                        </div>
                    </form>
                    @else
                        N/A
                    @endif--}}


                </div>
            </div>  <!-- end pick up row -->
        </div>
    </div>
@endsection