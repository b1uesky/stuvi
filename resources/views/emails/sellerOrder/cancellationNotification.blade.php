@extends('beautymail::templates.sunny')

@section('content')

    @include ('beautymail::templates.sunny.heading' , [
        'heading' => 'Order Cancellation',
        'level' => 'h1',
    ])

    @include('beautymail::templates.sunny.contentStart')

    <p>Hi {{ $seller_order->buyerOrder->buyer->first_name }},</p>

    <p>Unfortunately, the book <strong><a href="{{ url('textbook/buy/' . $seller_order->product->book->id) }}">{{ $seller_order->product->book->title }}</a></strong> you ordered on our website was cancelled by its seller.</p>

    <p>Seller has provided a message regarding to the reason of cancellation:</p>

    <blockquote>
        {{ $seller_order->cancel_reason }}
    </blockquote>

    @include('beautymail::templates.sunny.contentEnd')

    @include('beautymail::templates.sunny.button', [
            'title' => 'View order details',
            'link' => url('/order/buyer/' . $seller_order->buyerOrder->id)
    ])

@stop