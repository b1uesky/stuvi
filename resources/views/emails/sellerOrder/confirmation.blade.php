@extends('beautymail::templates.sunny')

@section('content')

    @include ('beautymail::templates.sunny.heading' , [
        'heading' => 'Your book has sold!',
        'level' => 'h1',
    ])

    @include('beautymail::templates.sunny.contentStart')

    <p>Hi {{ $first_name }},</p>

    <p>Your book <a href="{{ url('/order/seller/' . $seller_order->id) }}">{{ $book_title }}</a> has sold!</p>

    <p>Please schedule a pickup at your convenience by clicking the button below.</p>

    @include('beautymail::templates.sunny.contentEnd')

    @include('beautymail::templates.sunny.button', [
            'title' => 'Schedule pickup',
            'link' => url('/order/seller/' . $seller_order->id . '/schedulePickup')
    ])

@stop