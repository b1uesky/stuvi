@extends('app')

@section('content')
    <div class="container" xmlns="http://www.w3.org/1999/html">
        @if (Session::has('message'))
            <div class="flash-message">{{ Session::get('message') }}</div>
        @endif
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Make an order</div>

                    <div class="panel-body">

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

                        <form action="{{ action('OrderController@storeBuyerOrder') }}" method="POST">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="stripeAmount" value="{{ $total*100 }}">
                            <h1>1. Confirm order items:</h1></br>
                            @foreach ($items as $item)
                                Book title: {{ $item->name }} </br>
                                isbn:  {{ $item->options['item']->book->isbn }} </br>
                                price: {{ $item->price }} </br>
                                ----------------------------------------------------------------------------------------</br>
                            @endforeach

                            <h1>2. Shipping address:</h1></br>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Full name</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="addressee" value="{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}">
                                </div>
                            </div>
                            </br>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Address line 1</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="address_line1">
                                </div>
                            </div>
                            </br>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Address line 2</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="address_line2">
                                </div>
                            </div>
                            </br>
                            <div class="form-group">
                                <label class="col-md-4 control-label">City</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="city">
                                </div>
                            </div>
                            </br>
                            <div class="form-group">
                                <label class="col-md-4 control-label">State</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="state_a2">
                                </div>
                            </div>
                            </br>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Zip</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="zip">
                                </div>
                            </div>
                            </br>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Phone</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="phone_number">
                                </div>
                            </div>
                            </br>


                            <h1>3. Payment:</h1></br>
                            <script
                                    src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                                    data-key="pk_test_GWm6W90Pr0nrjbzWjPjZa8Ou"
                                    data-amount={{ $total*100 }}
                                    data-name="Demo Site"
                            data-description="2 widgets (${{ $total }})"
                            data-image="/128x128.png">
                            </script>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection