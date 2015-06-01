@extends('app')

@section('content')
    <div class="container">
        @if (Session::has('message'))
            <div class="flash-message">{{ Session::get('message') }}</div>
        @endif
    </div>
    <div class="container">
        <h1>Cart items:</h1>
        @forelse ($items as $item)
            {{ $item }}
        @empty
            <p>You don't have any product in shopping cart.</p>
        @endforelse

    </div>
@endsection