@extends('beautymail::templates.sunny')

@section('content')

    @include ('beautymail::templates.sunny.heading' , [
        'heading' => 'Welcome to Stuvi, ' . $first_name . '!',
        'level' => 'h1',
    ])

    @include('beautymail::templates.sunny.contentStart')

    <p>Please verify your Email address by clicking the button below:</p>

    @include('beautymail::templates.sunny.contentEnd')

    @include('beautymail::templates.sunny.button', [
            'title' => 'Confirm my account',
            'link' => url('/user/activate/'.$verification_code.'?return_to='.$return_to)
    ])

@stop
