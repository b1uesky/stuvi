@extends('app')

@section('content')
    <head>
        <title>Stuvi - Bookshelf</title>
        <link rel="stylesheet" type="text/css" href="{{asset('/css/bookshelf.css')}}">
    </head>


    <div class="container" xmlns="http://www.w3.org/1999/html">
        @if (Session::has('message'))
            <div class="flash-message">{{ Session::get('message') }}</div>
        @endif
    </div>


    <div class="container-fluid">

        <div class="container">
            <h1>{{ Auth::user()->first_name }}'s Bookshelf <small>Books for sale</small></h1>
        </div>

        <div class="container">
            <table class="table table-responsive for-sale-table">
                <!-- new row for each book -->
                <tr class="for-sale-item">
                    <td class="for-sale-img">
                        <img class="img-responsive" src="http://puu.sh/ijDe0/422ea24ff0.png" width="100px" height="150px"></td>
                    <td class="for-sale-info-1">
                        <span class="for-sale-title"><a href="#">Mein Kampf</a></span><br>
                        <span class="for-sale-author">by <a href="#">Adolf Hitler</a></span><br>

                        <span class="for-sale-binding">Hardcover</span><br>
                        <span class="for-sale-price">$18.00</span><br>
                        <button type="button" class="btn btn-link for-sale-btn-add-cart">
                            Add to Cart</button>
                    </td>
                    <td class="for-sale-info-2">
                        <span class="for-sale-pub-date text-muted">September 15, 1998</span><br>
                        <span class="for-sale-isbn">ISBN-10: 0395925037</span><br>
                        <span class="for-sale-lang">Language: German</span>
                        <span class="for-sale-pages">Pages:123</span><br>

                    </td>

                    <td class="for-sale-info-3">
                        <!-- each class the book support -->
                        <h5>Classes</h5>
                        <span class="for-sale-class"><a href="#">BU:SMG SM131</a></span>
                    </td>
                </tr>

            </table>
        </div>




{{--        <h1>Your buyer orders:</h1>
        @forelse ($orders as $order)
            <div class="row">
            <li><a href="{{ url('order/buyer/'.$order->id) }}">Order #{{ $order->id }}</a></li>
                --}}{{--
            <li>{{ $order->buyer_payment()->stripe_amount/100 }}</li>
            <p>Product info:</p><br>
            <li>{{ $order->product->book->title }}</li>
            <li>{{ $order->product->book->isbn }}</li>
            <li>{{ $order->product->book->author }}</li>
            --}}{{--
            --------------------------------------------------------------<br>
            </div>
        @empty
            <p>You don't have any orders.</p>
        @endforelse--}}

    </div>
@endsection