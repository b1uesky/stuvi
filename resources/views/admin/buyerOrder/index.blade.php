@extends('admin')

@section('title', 'Buyer Order')

@section('content')
    <table class="table table-hover">
        <tr>
            <th>ID</th>
            <th>Buyer ID</th>
            <th>Cancelled</th>
            <th>Delivered Time</th>
            <th>Created At</th>
            <th>Actions</th>
        </tr>

        @foreach($buyer_orders as $buyer_order)
            <tr>
                <td>{{ $buyer_order->id }}</td>
                <td>{{ $buyer_order->buyer_id }}</td>
                <td>{{ $buyer_order->cancelled }}</td>
                <td>{{ $buyer_order->time_delivered }}</td>
                <td>{{ $buyer_order->created_at }}</td>
                <td><a class="btn btn-info" role="button" href="{{ URL::to('admin/order/buyer/' . $buyer_order->id) }}">Details</a></td>
            </tr>
        @endforeach
    </table>
@endsection
