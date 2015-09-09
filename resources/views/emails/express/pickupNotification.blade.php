@extends('beautymail::templates.sunny')

@section('content')

    @include ('beautymail::templates.sunny.heading' , [
        'heading' => 'Pickup: Order #' . $seller_order_id,
        'level' => 'h1',
    ])

    @include('beautymail::templates.sunny.contentStart')

    <p>Book title: {{ $book_title }}</p>
    <p>Scheduled pickup time: {{ $time }}</p>

    @include('beautymail::templates.sunny.contentEnd')

    @include('beautymail::templates.sunny.button', [
            'title' => 'View pickup details',
            'link' => url('/express/pickup/' . $seller_order_id)
    ])

@stop