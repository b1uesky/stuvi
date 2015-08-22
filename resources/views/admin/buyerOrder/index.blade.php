@extends('layouts.admin')

@section('title', 'Buyer Order')

@section('content')
    {{--<div class="btn-group" role="group">--}}
        {{--<a href="{{ URL::to('admin/order/buyer') }}" class="btn btn-default">All</a>--}}
        {{--<a href="{{ URL::to('admin/order/buyer?filter=refund') }}" class="btn btn-default">Refundable Only</a>--}}
        {{--<a href="{{ URL::to('admin/order/buyer?filter=nonrefund') }}" class="btn btn-default">Nonrefundable Only</a>--}}
    {{--</div>--}}

    <h1>Buyer Orders</h1>

    <table class="table table-hover">
        <tr>
            <th>ID</th>
            <th>Buyer</th>
            <th>Cancelled</th>
            <th>Delivered Time</th>
            <th>Created At</th>
            <th>Actions</th>
        </tr>

        @foreach($buyer_orders as $buyer_order)
            <tr>
                <td>{{ $buyer_order->id }}</td>
                <td><a href="{{ url('admin/user/'.$buyer_order->buyer_id) }}">{{ $buyer_order->buyer->first_name }} {{ $buyer_order->buyer->last_name }}</a></td>
                <td>{{ $buyer_order->cancelled }}</td>
                <td>{{ $buyer_order->time_delivered }}</td>
                <td>{{ $buyer_order->created_at }}</td>
                <td><a class="btn btn-info" role="button" href="{{ URL::to('admin/order/buyer/' . $buyer_order->id) }}">Details</a></td>
            </tr>
        @endforeach
    </table>

    {!! $buyer_orders->render() !!}
@endsection
