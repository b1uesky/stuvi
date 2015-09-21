@extends('layouts.admin')

@section('title', 'Seller Order')

@section('content')

    <p><strong>Overview</strong></p>
    <table class="table table-hover">
        <tr>
            <th>ID</th>
            <td>{{ $seller_order->id }}</td>
        </tr>
        <tr>
            <th>Product</th>
            <td><a href="{{ url('admin/product/'.$seller_order->product_id) }}">{{ $seller_order->product->book->title }}</a></td>
        </tr>
        <tr>
            <th>BuyerOrder ID</th>
            <td><a href="{{ url('admin/order/buyer/'.$seller_order->buyer_order_id) }}">{{ $seller_order->buyer_order_id }}</a></td>
        </tr>
        <tr>
            <th>Cancelled</th>
            <td>
                {{ $seller_order->cancelled }} @if ($seller_order->cancelled) @ {{ $seller_order->cancelled_time }} @endif
            </td>
        </tr>
        <tr>
            <th>Created At</th>
            <td>{{ $seller_order->created_at }}</td>
        </tr>
        <tr>
            <th>Updated At</th>
            <td>{{ $seller_order->updated_at }}</td>
        </tr>
    </table>

    <p><strong>Delivery</strong></p>
    <table class="table table-hover">
        <tr>
            <th>Scheduled Pickup Time</th>
            <td>{{ $seller_order->scheduled_pickup_time }}</td>
        </tr>
        <tr>
            <th>Pickup Address</th>
            <td>
                @if ($seller_order->address)
                    {{ $seller_order->address->addressee }}<br>
                    {{ $seller_order->address->address_line1 }} {{ $seller_order->address->address_line2 }}<br>
                    {{ $seller_order->address->city }}, {{ $seller_order->address->state_a2 }} {{ $seller_order->address->zip }}<br>
                    P: {{ $seller_order->address->phone_number }}
                @endif
            </td>
        </tr>
        <tr>
            <th>Pickup Code</th>
            <td>{{ $seller_order->pickup_code }}</td>
        </tr>
        <tr>
            <th>Courier</th>
            <td>@if ($seller_order->courier)
                    <a href="{{ url('admin/user/'.$seller_order->courier->id) }}">{{ $seller_order->courier->first_name }} {{ $seller_order->courier->last_name }}</a>
                @endif
            </td>
        </tr>
        <tr>
            <th>Pickup Time</th>
            <td>{{ $seller_order->pickup_time }}</td>
        </tr>
    </table>

    <p><strong>Payout</strong></p>
    <table class="table table-hover">
        <tr>
            <th>Payout Item ID</th>
            <td>{{ $seller_order->payout_item_id }}</td>
        </tr>
    </table>

@endsection
