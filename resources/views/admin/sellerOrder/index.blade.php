@extends('layouts.admin')

@section('title', 'Seller Order')

@section('content')

    <table class="table table-condensed" data-sortable>
        <thead>
            <tr class="active">
                <th>ID</th>
                <th>Product</th>
                <th>Seller</th>
                <th>Cancelled</th>
                <th>Scheduled Pickup Time</th>
                <th>Pickup Time</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            @foreach($seller_orders as $seller_order)
                <tr>
                    <td>{{ $seller_order->id }}</td>
                    <td><a href="{{ url('admin/product/'.$seller_order->product_id) }}">{{ $seller_order->product->book->title }}</a></td>
                    <td><a href="{{ url('admin/user/'.$seller_order->seller()->id) }}">{{ $seller_order->seller()->first_name.' '.$seller_order->seller()->last_name }}</a></td>
                    <td>@if($seller_order->cancelled) Yes @else No @endif</td>
                    <td>{{ $seller_order->scheduled_pickup_time }}</td>
                    <td>{{ $seller_order->pickup_time }}</td>
                    <td>{{ $seller_order->created_at }}</td>
                    <td><a href="{{ url('admin/order/seller/' . $seller_order->id) }}"><span class="glyphicon glyphicon-eye-open"></span></a></td>
                </tr>
            @endforeach
        </tbody>

    </table>

    {!! $seller_orders->appends($pagination_params)->render() !!}
@endsection
