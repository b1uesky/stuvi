@extends('beautymail::templates.sunny')

@section('content')

    @include ('beautymail::templates.sunny.heading' , [
        'heading' => 'Delivered Notification',
        'level' => 'h1',
    ])

    @include('beautymail::templates.sunny.contentStart')

    <p>Hi {{ $first_name }},</p>

    <p>Your textbook {{ $book_title }} has been delivered and received by the book buyer.</p>

    @if($seller_order->product->payout_method == 'paypal')
        <p>You should receive your payment by PayPal shortly. If you have any question, feel free to <a href="{{ url('contact') }}">contact us</a>.</p>
    @endif

    @include('beautymail::templates.sunny.contentEnd')

    @include('beautymail::templates.sunny.button', [
            'title' => 'View order details',
            'link' => url('order/seller/'.$seller_order->id)
    ])

@stop