@extends('app')

@section('title', 'Order confirmation #'.Session::get('order')->id )

@section('css')
    <link href="{{ asset('/css/order_buyer_confirmation.css') }}" rel="stylesheet">
@endsection

@section('content')

        <!-- TODO: breadcrumb cart progress bar -->

    <div class="container confirmation-container container-main-content">
        <div class="confirmation-details">
            <h1>Thanks for using Stuvi!</h1>
            <h4>Your order number is: {{ Session::get('order')->id }}. <a href="{{ url('order/buyer/'.Session::get('order')->id) }}">View order details</a>.</h4>

            <p>You will receive an email confirmation shortly at <code>{{ Auth::user()->primaryEmail->email_address }}</code>.</p>
        </div>
        <div class="next-steps-container">
            <h1>Next Steps</h1>

            <p>You will receive another email shortly regarding the delivery time of your books.</p>

            <p>Please feel free to <a href="{{ url('/contact') }}">contact us</a> with any questions or concerns.</p>
        </div>
    </div>
@endsection

@section('javascript')
@endsection