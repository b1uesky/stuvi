@extends('beautymail::templates.sunny')

@section('content')

    @include ('beautymail::templates.sunny.heading' , [
        'heading' => 'Stuvi courier is ready to pickup your textbook',
        'level' => 'h1',
    ])

    @include('beautymail::templates.sunny.contentStart')

    <p>Hi {{ $first_name }},</p>

    <p>A Stuvi courier is ready to pickup your textbook <a href="{{ url('/order/seller/' . $seller_order_id) }}">{{ $book_title }}</a>!</p>

    <h2>Scheduled pickup time</h2>

    <blockquote>
        <span>{{ $time }}</span>
    </blockquote>

    <p>If you cannot make it, please call our courier at <strong>{{ $courier_phone_number }}</strong> as soon as possible.</p>

    <p>Once our courier has picked up your textbook, please show the following code to the courier: <strong>{{ $pickup_code }}</strong></p>

    @include('beautymail::templates.sunny.contentEnd')

@stop