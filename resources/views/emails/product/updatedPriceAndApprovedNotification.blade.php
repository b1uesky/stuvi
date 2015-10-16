@extends('beautymail::templates.sunny')

@section('content')

    @include ('beautymail::templates.sunny.heading' , [
        'heading' => 'Pickup Details Required',
        'level' => 'h1',
    ])

    @include('beautymail::templates.sunny.contentStart')

    <p>Hi {{ $first_name }},</p>

    <p>Congratulations, we have decided to buy your book <strong><a href="{{ url('textbook/buy/' . $seller_order->product->book->id) }}">{{ $book_title }}</a></strong> at the price of <span style="color: #F25F5C">${{ $seller_order->product->decimalPrice() }}</span>.</p>

    <p>If you have any questions regarding to the price, please feel free to <a href="{{ url('/contact') }}">contact us</a>.</p>

    <p>Before our courier coming to pick up your book, please provide us pickup details by clicking the button below:</p>

    @include('beautymail::templates.sunny.contentEnd')

    @include('beautymail::templates.sunny.button', [
            'title' => 'Schedule pickup',
            'link' => url('/order/seller/' . $seller_order->id . '/schedulePickup')
    ])

@stop