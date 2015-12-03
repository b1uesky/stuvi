@extends('beautymail::templates.sunny')

@section('content')

    @include ('beautymail::templates.sunny.heading' , [
        'heading' => 'Delivered Notification',
        'level' => 'h1',
    ])

    @include('beautymail::templates.sunny.contentStart')

    <p>Hi {{ $buyer_order->buyer->first_name }},</p>

    <p>Your order was delivered.</p>

    <h2>Details</h2>

    <hr>

    <ol>
        @foreach($buyer_order->products() as $product)
            <li><a href="{{ url('textbook/buy/product/' . $product->id) }}">{{ $product->book->title }}</a></li>
        @endforeach
    </ol>

    <p>Delivered to:</p>

    <?php $address = $buyer_order->shipping_address; ?>

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

    @include('beautymail::templates.sunny.contentEnd')

    @include('beautymail::templates.sunny.button', [
            'title' => 'View order details',
            'link' => url('order/buyer/'.$buyer_order->id)
    ])

@stop