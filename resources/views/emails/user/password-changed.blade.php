@extends('beautymail::templates.sunny')

@section('content')

    @include ('beautymail::templates.sunny.heading' , [
        'heading' => 'Password Changed',
        'level' => 'h1',
    ])

    @include('beautymail::templates.sunny.contentStart')

    <p>Hi {{ $user->first_name }},</p>

    <p>The password for your Stuvi Account - {{ $user->primaryEmailAddress() }} - was recently changed.</p>

    <p>If you didn't change your password, please contact us at {{ config('customer_service.phone') }} as soon as possible.</p>

    @include('beautymail::templates.sunny.contentEnd')

@stop
