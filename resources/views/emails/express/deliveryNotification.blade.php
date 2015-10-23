@extends('beautymail::templates.sunny')

@section('content')

    @include ('beautymail::templates.sunny.heading' , [
        'heading' => 'Delivery: Order #' . $buyer_order_id,
        'level' => 'h1',
    ])

    @include('beautymail::templates.sunny.contentStart')

    <p>Scheduled delivery time: {{ $scheduled_delivery_time }}</p>

    @include('beautymail::templates.sunny.contentEnd')

    @include('beautymail::templates.sunny.button', [
            'title' => 'View delivery details',
            'link' => url('/express/deliver/' . $buyer_order_id)
    ])

@stop
