@extends('beautymail::templates.sunny')

@section('content')

    @include ('beautymail::templates.sunny.heading' , [
        'heading' => 'Order Confirmation',
        'level' => 'h1',
    ])

    @include('beautymail::templates.sunny.contentStart')

    <?php
    $count_items = count($buyer_order->seller_orders);
    $address = $buyer_order->shipping_address;
    ?>

    <p>Hi {{ $first_name }},</p>

    <p>Thank you for shopping with us. You ordered the following {{ $count_items > 1 ? 'items' : 'item' }}:</p>

    <ol>
        @foreach($buyer_order->products() as $product)
            <li><a href="{{ url('textbook/buy/product/' . $product->id) }}">{{ $product->book->title }}</a></li>
        @endforeach
    </ol>

    <h2>Details</h2>

    <hr>
    
    <p>Ship to:</p>

    <address>
        {{ $address->addressee }}<br>
        {{ $address->address_line1 }}
        @if($address->address_line2)
            , {{ $address->address_line2 }}
        @endif
        <br>
        {{ $address->city }}, {{ $address->state_a2 }} {{ $address->zip }}
    </address>

    <br>

    <p>
        Total before tax: ${{ $buyer_order->subtotal }}<br>
        Tax collected: ${{ $buyer_order->tax }}<br>
        <strong>Grand total: ${{ $buyer_order->amount }}</strong>
    </p>

    <p>Once your order is ready, we will notify you to schedule a delivery.</p>

    @include('beautymail::templates.sunny.contentEnd')

    @include('beautymail::templates.sunny.button', [
            'title' => 'View order details',
            'link' => url('order/buyer/' . $buyer_order->id)
    ])

@stop