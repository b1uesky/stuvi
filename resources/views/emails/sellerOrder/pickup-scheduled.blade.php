@extends('beautymail::templates.sunny')

@section('content')

    @include ('beautymail::templates.sunny.heading' , [
        'heading' => 'Pickup Scheduled',
        'level' => 'h1',
    ])

    @include('beautymail::templates.sunny.contentStart')

    <?php $address = $seller_order->address; ?>

    <p>Hi {{ $first_name }},</p>

    <p>You have successfully scheduled the pickup for your textbook <a href="{{ url('/order/seller/' . $seller_order->id) }}">{{ $book_title }}</a>!</p>

    <h2>Scheduled pickup address</h2>

    <address>
        {{ $address->addressee }}<br>
        {{ $address->address_line1 }}
        @if($address->address_line2)
            , {{ $address->address_line2 }}
        @endif
        <br>
        {{ $address->city }}, {{ $address->state_a2 }} {{ $address->zip }}<br>
        {{ $address->phone_number }}
    </address>

    <br>

    <h2>Scheduled pickup time</h2>

    <p>{{ \App\Helpers\DateTime::showDatetime($seller_order->scheduled_pickup_time) }}</p>

    <p>You can <a href="{{ url('/order/seller/'.$seller_order->id.'/schedulePickup') }}">reschedule</a> the pickup before it is assigned to our courier.</p>

    <p>Once our courier has picked up your textbook, please show the following code to the courier: <strong>{{ $seller_order->pickup_code }}</strong></p>

    @include('beautymail::templates.sunny.contentEnd')

@stop