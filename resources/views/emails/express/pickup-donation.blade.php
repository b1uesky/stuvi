@extends('beautymail::templates.sunny')

@section('content')

    @include ('beautymail::templates.sunny.heading' , [
        'heading' => 'Pickup: Donation #' . $donation->id,
        'level' => 'h1',
    ])

    @include('beautymail::templates.sunny.contentStart')

    <p>Scheduled pickup time: {{ $scheduled_pickup_time }}</p>

    @include('beautymail::templates.sunny.contentEnd')

    @include('beautymail::templates.sunny.button', [
            'title' => 'View pickup details',
            'link' => url('/express/pickup/donation/' . $donation->id)
    ])

@stop