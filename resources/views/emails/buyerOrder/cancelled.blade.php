@extends('beautymail::templates.sunny')

@section('content')

    @include ('beautymail::templates.sunny.heading' , [
        'heading' => 'Order Cancellation',
        'level' => 'h1',
    ])

    @include('beautymail::templates.sunny.contentStart')

    <p>Hi {{ $buyer_order->buyer->first_name }},</p>

    <p>You have successfully cancelled your order of following {{ count($buyer_order->seller_orders) > 1 ? 'items' : 'item' }}:</p>

    <ol>
        @foreach($buyer_order->products() as $product)
            <li><a href="{{ url('textbook/buy/product/' . $product->id) }}">{{ $product->book->title }}</a></li>
        @endforeach
    </ol>

    @include('beautymail::templates.sunny.contentEnd')

    @include('beautymail::templates.sunny.button', [
            'title' => 'View order details',
            'link' => url('order/buyer/' . $buyer_order->id)
    ])

@stop