@extends('beautymail::templates.sunny')

@section('content')

    @include ('beautymail::templates.sunny.heading' , [
        'heading' => 'Message',
        'level' => 'h1',
    ])

    @include('beautymail::templates.sunny.contentStart')

    <p>{{ $contact->message }}</p>

    <hr>

    <p>Name: {{ $contact->name }}</p>
    <p>Time: {{ $contact->created_at }}</p>

    @include('beautymail::templates.sunny.contentEnd')

@stop