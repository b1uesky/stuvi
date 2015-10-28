@extends('beautymail::templates.sunny')

@section('content')

    @include ('beautymail::templates.sunny.heading' , [
        'heading' => 'Pickup Notification',
        'level' => 'h1',
    ])

    @include('beautymail::templates.sunny.contentStart')

    <?php $address = $seller_order->address; ?>

    <p>Hi {{ $first_name }},</p>

    <p>A Stuvi courier is ready to pickup your textbook <a href="{{ url('/order/seller/' . $seller_order->id) }}">{{ $book_title }}</a>!</p>

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

    <h2>Scheduled pickup time</h2>

    <p>{{ \App\Helpers\DateTime::showDatetime($seller_order->scheduled_pickup_time) }}</p>

    <p>If you cannot make it, please call our courier at <strong>{{ $seller_order->courier->phone_number }}</strong> as soon as possible.</p>

    <p>Once our courier has arrived, please show the following code to the courier: <strong>{{ $seller_order->pickup_code }}</strong></p>

    @include('beautymail::templates.sunny.contentEnd')

@stop