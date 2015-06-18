@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <p>Order #{{ $order['id'] }} is confirmed. We will email you when the book is ready.</p>
        </div>
    </div>
@endsection