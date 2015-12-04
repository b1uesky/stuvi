@extends('layouts.admin')

@section('title', 'Buyer Order')

@section('content')

    <table class="table table-condensed">
        <caption>Details</caption>

        <tr>
            <th>ID</th>
            <td>{{ $buyer_order->id }}</td>
        </tr>
        <tr>
            <th>Buyer</th>
            <td><a href="{{ url('admin/user/'.$buyer_order->buyer_id) }}">{{ $buyer_order->buyer->first_name }} {{ $buyer_order->buyer->last_name }}</a></td>
        </tr>
        <tr>
            <th>Scheduled delivery time</th>
            <td>{{ \App\Helpers\DateTime::showDatetime($buyer_order->scheduled_delivery_time) }}</td>
        </tr>
        <tr>
            <th>Delivered time</th>
            <td>{{ \App\Helpers\DateTime::showDatetime($buyer_order->time_delivered) }}</td>
        </tr>
        <tr>
            <th>Shipping Address</th>
            <td>{{ $buyer_order->shipping_address->addressee }}<br>
                {{ $buyer_order->shipping_address->address_line1 }} {{ $buyer_order->shipping_address->address_line2 }}<br>
                {{ $buyer_order->shipping_address->city }}, {{ $buyer_order->shipping_address->state_a2 }} {{ $buyer_order->shipping_address->zip }}<br>
                P: {{ $buyer_order->shipping_address->phone_number }}
            </td>
        </tr>
        <tr>
            <th>Courier</th>
            <td>
                @if($buyer_order->courier_id)
                    <a href="{{ url('admin/user/'.$buyer_order->courier_id) }}">{{ $buyer_order->courier->first_name }} {{ $buyer_order->courier->last_name }}
                    </a>
                @endif
            </td>
        </tr>
        <tr>
            <th>Items</th>
            <td>
            <table>
                @foreach($buyer_order->seller_orders as $seller_order)
                    <tr>
                        <a href="{{ url('admin/order/seller/'.$seller_order->id) }}">{{ $seller_order->product->book->title }}</a><br>
                    </tr>
                @endforeach
            </table>
            </td>
        </tr>
        <tr>
            <th>Cancelled</th>
            <td>{{ $buyer_order->cancelled }}
                @if ($buyer_order->cancelled)
                    @ {{ $buyer_order->cancelled_time }}
                @endif
            </td>
        </tr>
    </table>


    <table class="table table-condensed" data-sortable>
        <caption>Payment</caption>

        <thead>
            <tr class="active">
                <th>Payment method</th>
                <th>Subtotal</th>
                <th>Discount</th>
                <th>Shipping</th>
                <th>Tax</th>
                <th>Total</th>
                @if($buyer_order->payment_method == 'paypal')
                    <th>Authorization ID</th>
                    <th>Capture ID</th>
                @endif
            </tr>
        </thead>

        <tbody>
            <tr>
                <td>{{ $buyer_order->payment_method }}</td>
                <td>${{ $buyer_order->subtotal }}</td>
                <td>- ${{ $buyer_order->discount }}</td>
                <td>${{ $buyer_order->shipping }}</td>
                <td>${{ $buyer_order->tax }}</td>
                <td class="price">${{ $buyer_order->amount }}</td>
                @if($buyer_order->payment_method == 'paypal')
                    <td>{{ $buyer_order->authorization_id }}</td>
                    <td>{{ $buyer_order->capture_id }}</td>
                @endif
            </tr>
        </tbody>

    </table>

@endsection
