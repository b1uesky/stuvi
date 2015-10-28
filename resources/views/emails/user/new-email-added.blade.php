@extends('beautymail::templates.sunny')

@section('content')

    @include ('beautymail::templates.sunny.heading' , [
        'heading' => 'Email Address Confirmation',
        'level' => 'h1',
    ])

    @include('beautymail::templates.sunny.contentStart')

    <p>Hi {{ $email->user->first_name }},</p>

    <p>You recently added this email address to your Stuvi account. Please click the button below to verify your email address.</p>

    @include('beautymail::templates.sunny.contentEnd')

    @include('beautymail::templates.sunny.button', [
            'title' => 'Confirm email address',
            'link' => url('/user/email/' . $email->id . '/verify/' . $email->verification_code)
    ])

@stop