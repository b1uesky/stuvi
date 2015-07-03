@extends('admin')

@section('content')

    <table class="table table-hover">
        <tr>
            <th>ID</th>
            <td>{{ $sellerOrder->id }}</td>
        </tr>
        <tr>
            <th>Product ID</th>
            <td>{{ $sellerOrder->product_id }}</td>
        </tr>
        <tr>
            <th>BuyerOrder ID</th>
            <td>{{ $sellerOrder->buyer_order_id }}</td>
        </tr>
        <tr>
            <th>Cancelled</th>
            <td>{{ $sellerOrder->cancelled }}</td>
        </tr>
        <tr>
            <th>Scheduled Pickup Time</th>
            <td>{{ $sellerOrder->scheduled_pickup_time }}</td>
        </tr>
        <tr>
            <th>Pickup Time</th>
            <td>{{ $sellerOrder->pickup_time }}</td>
        </tr>
    </table>

@endsection
