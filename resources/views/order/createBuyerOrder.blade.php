@extends('app')

@section('content')
    <head>
        <link href="{{ asset('/css/createBuyerOrder.css') }}" rel="stylesheet">
        <title>Stuvi - Checkout</title>
    </head>

    @if (Session::has('message'))
        <div class="container" id="message-cont" xmlns="http://www.w3.org/1999/html">
            <div class="flash-message" id="message"><i class="fa fa-exclamation-triangle"></i> {{ Session::get('message') }}</div>
        </div>
    @endif

    <div class="row back-row">
        <a id="back-to-cart" href="{{ url('/cart') }}"><i class="fa fa-arrow-circle-left"></i>Back to Cart</a>
    </div>
    <div class="container col-xs-12 col-xs-offset-2 col-sm-8 col-sm-offset-2 cart-progress">
        <img class="img-responsive cart-line col-sm-offset-3" src="{{asset('/img/CHECKOUT.png')}}" alt="Your cart progress">
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

                    <form action="{{ action('Textbook\OrderController@storeBuyerOrder') }}" method="POST">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="stripeAmount" value="{{ $total*100 }}">
                        <h2>1. Confirm order items</h2></br>
                        {{--@foreach ($items as $item)--}}
                            {{--Book title: {{ $item->name }} </br>--}}
                            {{--Isbn:  {{ $item->options['item']->book->isbn }} </br>--}}
                            {{--Price: ${{ $item->price }} </br>--}}
                            {{------------------------------------------------------------------------------------------</br>--}}
                        {{--@endforeach--}}

                        <table class="table table-striped table-responsive cart-table">
                            <tr>
                                <th>Book Title</th>
                                <th>ISBN</th>
                                <th>Price</th>
                            </tr>

                            @forelse ($items as $item)
                                <tr>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->options['item']->book->isbn }}</td>
                                    <td>${{ $item->price }}</td>
                                    @if ($item->options['item']->sold())
                                        <p>Warning: This product has been sold.</p>
                                    @endif
                                </tr>
                            @empty
                                <p>You don't have any products in shopping cart.</p>
                            @endforelse

                        </table>

                        <h2>2. Shipping address</h2></br>
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


                        <h2>3. Payment <small>Secure Payment via Stripe</small></h2></br>
                        <script src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                                data-key="pk_test_1buT5EQ82ha2RhVa4nfXqifR"
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
@endsection