@extends('beautymail::templates.sunny')

@section('content')

    @include ('beautymail::templates.sunny.heading' , [
        'heading' => 'Textbook Photo Required',
        'level' => 'h1',
    ])

    @include('beautymail::templates.sunny.contentStart')

    <p>Hi {{ $first_name }},</p>

    <p>We notice that one or more textbook photos you uploaded for
        <strong><a href="{{ url('textbook/buy/' . $product->book->id) }}">{{ $book_title }}</a></strong>
        are not descriptive enough.
        To help others understand your book conditions better, it is important to have at least one front cover photo taken by cell phone or camera.</p>

    <p>You can update your textbook photos by clicking the button below:</p>

    @include('beautymail::templates.sunny.contentEnd')

    @include('beautymail::templates.sunny.button', [
            'title' => 'Edit your book',
            'link' => url('/textbook/sell/product/'.$product->id.'/edit')
    ])

@stop