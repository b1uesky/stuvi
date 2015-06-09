@extends('app')
<link href="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/css/bootstrap-combined.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" media="screen"
      href="http://tarruda.github.com/bootstrap-datetimepicker/assets/css/bootstrap-datetimepicker.min.css">
@section('content')
    <div class="container" xmlns="http://www.w3.org/1999/html">
        @if (Session::has('message'))
            <div class="flash-message">{{ Session::get('message') }}</div>
        @endif
    </div>
    <div class="container">
        <h1>Order #{{ $seller_order->id }} @if ($seller_order->cancelled) (CANCELLED) @endif</h1>
        @if (!$seller_order->cancelled)
            <p><a href="/order/seller/cancel/{{ $seller_order->id }}">Cancel Order</a></p>
        @endif

        <p>{{ $seller_order->created_at }}</p>

        <div class="container">
            <div class="row">
                <?php $product = $seller_order->product; $book = $product->book; ?>
                <p><label class="col-md-4 control-label">Title: {{ $book->title }}</label></p>
                <p><label class="col-md-4 control-label">ISBN: {{ $book->isbn }}</label></p>
                <p><label class="col-md-4 control-label">Price: {{ $product->price }}</label></p>
            </div>
            <div class="row">
                <p><label class="col-md-4 control-label">Scheduled pick-up time:</label>
                    @if ($seller_order->scheduled_pickup_time)
                        {{ date($datetime_format, $seller_order->scheduled_pickup_time) }}
                    @else
                    <form action="{{ url('/order/seller/setscheduledtime') }}" method="POST">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="id" value="{{ $seller_order->id }}">

                        <div class="form-group">
                        <div id="datetimepicker" class="input-append date">
                            <input type="text" name="scheduled_pickup_time"></input>
                          <span class="add-on">
                            <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
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
                    @endif
                </p>

            </div>
        </div>

    </div>

@endsection