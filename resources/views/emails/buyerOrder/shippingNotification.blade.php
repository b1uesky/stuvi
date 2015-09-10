@extends('beautymail::templates.sunny')

@section('content')

    @include ('beautymail::templates.sunny.heading' , [
        'heading' => 'Shipping Notification',
        'level' => 'h1',
    ])

    @include('beautymail::templates.sunny.contentStart')

    <p>Hi {{ $buyer_order_arr['buyer']['first_name'] }},</p>

    <p>Your order is out for delivery by a Stuvi Courier!</p>

    <h2>Details</h2>

    <hr>

    @foreach($buyer_order_arr['products'] as $product)
        
    @endforeach

    @include('beautymail::templates.sunny.contentEnd')

    @include('beautymail::templates.sunny.button', [
            'title' => 'View order details',
            'link' => url('order/buyer/'.$buyer_order_arr['id'])
    ])

@stop