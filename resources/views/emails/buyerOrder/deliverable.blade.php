@extends('beautymail::templates.sunny')

@section('content')

    @include ('beautymail::templates.sunny.heading' , [
        'heading' => 'Schedule a delivery time',
        'level' => 'h1',
    ])

    @include('beautymail::templates.sunny.contentStart')

    <p>Hi {{ $first_name }},</p>

    <p>Your order is ready to ship!</p>

    <ol>
        @foreach($buyer_order->products() as $product)
            <li><a href="{{ url('textbook/buy/product/' . $product->id) }}">{{ $product->book->title }}</a></li>
        @endforeach
    </ol>

    <p>Please schedule a delivery at your convenience by clicking the button below:</p>

    @include('beautymail::templates.sunny.contentEnd')

    @include('beautymail::templates.sunny.button', [
            'title' => 'Schedule delivery',
            'link' => url('/order/buyer/' . $buyer_order->id . '/scheduleDelivery')
    ])

@stop