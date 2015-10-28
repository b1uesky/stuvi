@extends('beautymail::templates.sunny')

@section('content')

    @include ('beautymail::templates.sunny.heading' , [
        'heading' => 'Schedule a delivery time',
        'level' => 'h1',
    ])

    @include('beautymail::templates.sunny.contentStart')

    <p>Hi, {{ $first_name }}</p>

    <p>Your order on Stuvi is ready to ship!</p>

    <p>Please schedule a delivery at your convenience by clicking the button below:</p>

    @include('beautymail::templates.sunny.contentEnd')

    @include('beautymail::templates.sunny.button', [
            'title' => 'Schedule delivery',
            'link' => url('/order/buyer/' . $buyer_order_id . '/scheduleDelivery')
    ])

@stop