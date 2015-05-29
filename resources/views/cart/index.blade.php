@extends('app')

@section('content')
    <div class="container">

        @forelse ($products as $product)
            {{ $product }}
            {{ $product->product->seller_id }}
        @empty
            <p>You don't have any product in shopping cart.</p>
        @endforelse

    </div>
@endsection