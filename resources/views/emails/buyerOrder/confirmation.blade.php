@extends('beautymail::templates.sunny')

@section('content')

    @include ('beautymail::templates.sunny.heading' , [
        'heading' => 'Order Confirmation',
        'level' => 'h1',
    ])

    @include('beautymail::templates.sunny.contentStart')

    <p>Hi {{ $first_name }},</p>

    <p>Thank you for shopping with us. We will let you know when your order is on its way!</p>

    @include('beautymail::templates.sunny.contentEnd')

    @include('beautymail::templates.sunny.button', [
            'title' => 'View order details',
            'link' => url('order/buyer/' . $buyer_order_id)
    ])

@stop