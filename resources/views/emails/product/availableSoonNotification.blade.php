@extends('beautymail::templates.sunny')

@section('content')

    @include ('beautymail::templates.sunny.heading' , [
        'heading' => 'Pickup Details Required',
        'level' => 'h1',
    ])

    @include('beautymail::templates.sunny.contentStart')

    <p>Hi {{ $first_name }},</p>

    <p>We noticed that you have not yet scheduled a pickup for your book <strong><a href="{{ url('textbook/buy/' . $product->book->id) }}">{{ $book_title }}</a></strong>, available on {{ \Carbon\Carbon::parse($product->available_at)->toDateString() }}, which was sold a while ago.</p>

    <p>Please do so by clicking the button below:</p>

    @include('beautymail::templates.sunny.contentEnd')

    @include('beautymail::templates.sunny.button', [
            'title' => 'Schedule pickup',
            'link' => url('/order/seller/' . $product->currentSellerOrder()->id . '/schedulePickup')
    ])

@stop