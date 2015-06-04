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
                            <h1>Confirm order items:</h1></br>
                            @foreach ($items as $item)
                                Book title: {{ $item->name }} </br>
                                isbn:  {{ $item->options['item']->book->isbn }} </br>
                                price: {{ $item->price }} </br>
                                ----------------------------------------------------------------------------------------</br>
                            @endforeach

                            @include('addresses::fields') <!-- bootstrap fields with no form tags -->

                            @foreach($addresses as $address)
                                @include('addresses::view', compact('separator'=>'<br>')) <!-- read-only html of address -->
                            @endforeach

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