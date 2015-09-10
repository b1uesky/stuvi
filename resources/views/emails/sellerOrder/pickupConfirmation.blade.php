@extends('beautymail::templates.sunny')

@section('content')

    @include ('beautymail::templates.sunny.heading' , [
        'heading' => 'Pickup Confirmation',
        'level' => 'h1',
    ])

    @include('beautymail::templates.sunny.contentStart')

    <p>Hi {{ $first_name }},</p>

    <p>You have successfully scheduled the pickup for your textbook <a href="{{ url('/order/seller/' . $seller_order_id) }}">{{ $book_title }}</a>!</p>

    <h2>Scheduled pickup address</h2>

    <blockquote>
        <address>
            {{ $addressee }}<br>
            {{ $address_line1 }}
            @if($address_line2)
                , {{ $address_line2 }}
            @endif
            <br>
            {{ $city }}, {{ $state_a2 }} {{ $zip }}<br>
            {{ $phone_number }}
        </address>
    </blockquote>

    <h2>Scheduled pickup time</h2>

    <blockquote>
        <span>{{ $time }}</span>
    </blockquote>

    <p>You can <a href="{{ url('/order/seller/'.$seller_order_id.'/schedulePickup') }}">reschedule</a> the pickup before it is assigned to our courier.</p>

    <p>Once our courier has picked up your textbook, please show the following code to the courier: <strong>{{ $pickup_code }}</strong></p>

    @include('beautymail::templates.sunny.contentEnd')

@stop