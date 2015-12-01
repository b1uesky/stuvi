@extends('beautymail::templates.sunny')

@section('content')

    @include ('beautymail::templates.sunny.heading' , [
        'heading' => 'Textbook Trade-In',
        'level' => 'h1',
    ])

    @include('beautymail::templates.sunny.contentStart')

    <p>Hi {{ $first_name }},</p>

    <p>We notice that you are interested in trading in your book <strong><a href="{{ url('textbook/buy/' . $seller_order->product->book->id) }}">{{ $book_title }}</a></strong> to Stuvi, after careful review, we would like to purchase the book at a price of <span style="color: #F25F5C">${{ $seller_order->product->trade_in_price }}</span>.</p>

    <p>If you no longer wish to trade-in your book, please ignore this email.</p>

    <p>If you do like to trade it in, please schedule a book pickup by clicking the button below:</p>

    @include('beautymail::templates.sunny.contentEnd')

    @include('beautymail::templates.sunny.button', [
            'title' => 'Schedule pickup',
            'link' => url('/order/seller/' . $seller_order->id . '/schedulePickup')
    ])

@stop