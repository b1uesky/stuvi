@extends('beautymail::templates.sunny')

@section('content')

    @include ('beautymail::templates.sunny.heading' , [
        'heading' => 'Order Cancellation',
        'level' => 'h1',
    ])

    @include('beautymail::templates.sunny.contentStart')

    <p>Hi {{ $seller_order->seller()->first_name }},</p>

    <p>You have cancelled the order <strong><a href="{{ url('textbook/buy/' . $seller_order->product->book->id) }}">{{ $seller_order->product->book->title }}</a></strong>. The book is now off-the-shelf.</p>

    @include('beautymail::templates.sunny.contentEnd')

@stop