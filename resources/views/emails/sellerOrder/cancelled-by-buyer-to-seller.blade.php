@extends('beautymail::templates.sunny')

@section('content')

    @include ('beautymail::templates.sunny.heading' , [
        'heading' => 'Order Cancellation',
        'level' => 'h1',
    ])

    @include('beautymail::templates.sunny.contentStart')

    <p>Hi {{ $seller_order->seller()->first_name }},</p>

    <p>Unfortunately, your book buyer has decided not to purchase your book <strong><a href="{{ url('textbook/buy/' . $seller_order->product->book->id) }}">{{ $seller_order->product->book->title }}</a></strong> and cancelled the order.</p>

    <p>However, the book is available again on our website and we will definitely let you know if someone else buys your book.</p>

    @include('beautymail::templates.sunny.contentEnd')

@stop