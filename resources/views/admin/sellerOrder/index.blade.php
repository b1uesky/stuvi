@extends('admin')

@section('title', 'Seller Order')

@section('content')

    <h1>Seller Orders</h1>

    <table class="table table-hover">
        <tr>
            <th>ID</th>
            <th>Product</th>
            <th>Cancelled</th>
            <th>Scheduled Pickup Time</th>
            <th>Pickup Time</th>
            <th>Created At</th>
            <th>Actions</th>
        </tr>

        @foreach($seller_orders as $seller_order)
            <tr>
                <td>{{ $seller_order->id }}</td>
                <td><a href="{{ url('admin/product/'.$seller_order->product_id) }}">{{ $seller_order->product->book->title }}</a></td>
                <td>{{ $seller_order->cancelled }}</td>
                <td>{{ $seller_order->scheduled_pickup_time }}</td>
                <td>{{ $seller_order->pickup_time }}</td>
                <td>{{ $seller_order->created_at }}</td>
                <td><a class="btn btn-info" role="button" href="{{ URL::to('admin/order/seller/' . $seller_order->id) }}">Details</a></td>
            </tr>
        @endforeach
    </table>

    {!! $seller_orders->render() !!}
@endsection
