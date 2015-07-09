@extends('admin')

@section('title', 'Buyer Order')

@section('content')

    <table class="table table-hover">
        <tr>
            <th>ID</th>
            <td>{{ $buyer_order->id }}</td>
        </tr>
        <tr>
            <th>Buyer ID</th>
            <td>{{ $buyer_order->buyer_id }}</td>
        </tr>
        <tr>
            <th>Courier ID</th>
            <td>{{ $buyer_order->courier_id }}</td>
        </tr>
        <tr>
            <th>Cancelled</th>
            <td>{{ $buyer_order->cancelled }}</td>
        </tr>
        <tr>
            <th>Cancelled Time</th>
            <td>{{ $buyer_order->cancelled_time }}</td>
        </tr>
        <tr>
            <th>Delivered Time</th>
            <td>{{ $buyer_order->time_delivered }}</td>
        </tr>
        <tr>
            <th>Shipping Address</th>
            <td>{{ $buyer_order->shipping_address->address_line1 }} {{ $buyer_order->shipping_address->address_line2 }}</td>

        </tr>
    </table>

@endsection
