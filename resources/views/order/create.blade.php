@extends('app')

@section('content')
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

                        <form action="{{ action('OrderController@store') }}" method="POST">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="product_id" value="{{ $product['id'] }}">
                            <input type="hidden" name="stripeAmount" value="{{ $product['price']*100 }}">
                            <p>{{ $book['title'] }}</p>
                            <p>{{ $book['author'] }}</p>
                            <p>{{ $book['isbn'] }}</p>
                            <p>{{ $product['price'] }}</p>
                            <script
                                    src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                                    data-key="pk_test_GWm6W90Pr0nrjbzWjPjZa8Ou"
                                    data-amount={{ $product['price']*100 }}
                                    data-name="Demo Site"
                                    data-description="2 widgets (${{ $product['price'] }})"
                                    data-image="/128x128.png">
                            </script>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection