@extends('beautymail::templates.sunny')

@section('content')

    @include ('beautymail::templates.sunny.heading' , [
        'heading' => 'Book Not Accepted',
        'level' => 'h1',
    ])

    @include('beautymail::templates.sunny.contentStart')

    <p>Hi {{ $first_name }},</p>

    <p>Unfortunately, the book <strong><a href="{{ url('textbook/buy/' . $product->book->id) }}">{{ $book_title }}</a></strong> you sold was not accepted by Stuvi.</p>

    <p>We have provided a message regarding to the reason of rejection:</p>

    <blockquote>
        {{ $product->rejected_reason }}
    </blockquote>

    <p>If you have any questions, please contact us by clicking the button below:</p>

    @include('beautymail::templates.sunny.contentEnd')

    @include('beautymail::templates.sunny.button', [
            'title' => 'Contact us',
            'link' => url('/contact')
    ])

@stop