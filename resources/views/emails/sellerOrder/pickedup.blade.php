@extends('beautymail::templates.sunny')

@section('content')

    @include ('beautymail::templates.sunny.heading' , [
        'heading' => 'Pickedup Notification',
        'level' => 'h1',
    ])

    @include('beautymail::templates.sunny.contentStart')

    <p>Hi {{ $first_name }},</p>

    <p>Your textbook {{ $book_title }} has been picked up at {{ \App\Helpers\DateTime::showDatetime($seller_order->pickup_time) }}.</p>

    <p>If you have any question, feel free to <a href="{{ url('contact') }}">contact us</a>.</p>

    @include('beautymail::templates.sunny.contentEnd')

    @include('beautymail::templates.sunny.button', [
            'title' => 'View order details',
            'link' => url('order/seller/'.$seller_order->id)
    ])

@stop