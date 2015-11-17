@extends('beautymail::templates.sunny')

@section('content')

    @include ('beautymail::templates.sunny.heading' , [
        'heading' => 'Reminder: New Textbook Available',
        'level' => 'h1',
    ])

    @include('beautymail::templates.sunny.contentStart')

    <p>Hi {{ $user->first_name }},</p>

    <p>This is a reminder that a new textbook <a href="{{ url('textbook/buy/product/' . $product->id) }}">{{ $book->title }}</a> is now available on Stuvi.</p>

    <p>To manage your reminders, <a href="{{ url('user/reminder') }}">click here</a>.</p>

    @include('beautymail::templates.sunny.contentEnd')

    @include('beautymail::templates.sunny.button', [
            'title' => 'View details',
            'link' => url('textbook/buy/product/' . $product->id)
    ])

@stop