@extends('beautymail::templates.sunny')

@section('content')

    @include ('beautymail::templates.sunny.heading' , [
        'heading' => 'Pickup Notification',
        'level' => 'h1',
    ])

    @include('beautymail::templates.sunny.contentStart')

    <p>Hi {{ $first_name }},</p>

    <p>A Stuvi courier is ready to pickup the books you donated!</p>

    <h2>Scheduled pickup time</h2>

    <blockquote>
        <span>{{ $scheduled_pickup_time }}</span>
    </blockquote>

    <p>If you cannot make it, please call our courier at <strong>{{ $courier_phone_number }}</strong> as soon as possible.</p>

    <p>Once our courier has picked up your books, please show the following code to the courier: <strong>{{ $pickup_code }}</strong></p>

    @include('beautymail::templates.sunny.contentEnd')

@stop