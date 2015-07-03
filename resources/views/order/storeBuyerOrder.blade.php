@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <p>Order #{{ $order['id'] }} is confirmed. We will email you when the book is ready.</p>
        </div>
    </div>
@endsection

@section('javascript')
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
@endsection