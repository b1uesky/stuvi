@extends('beautymail::templates.sunny')

@section('content')

    @include ('beautymail::templates.sunny.heading' , [
        'heading' => 'Order Cancellation',
        'level' => 'h1',
    ])

    @include('beautymail::templates.sunny.contentStart')

    <p>Hi {{ $buyer_order->buyer->first_name }},</p>

    <p>You have successfully cancelled your order.</p>

    @include('beautymail::templates.sunny.contentEnd')

    @include('beautymail::templates.sunny.button', [
            'title' => 'View order details',
            'link' => url('order/buyer/' . $buyer_order->id)
    ])

@stop