@extends('layouts.admin')

@section('title', 'Buyer Order')

@section('content')

    <table class="table table-condensed" data-sortable>
        <thead>
            <tr class="active">
                <th>ID</th>
                <th>Buyer</th>
                <th>Cancelled</th>
                <th>Scheduled delivery time</th>
                <th>Delivered time</th>
                <th>Created at</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            @foreach($buyer_orders as $buyer_order)
                <tr>
                    <td>{{ $buyer_order->id }}</td>
                    <td><a href="{{ url('admin/user/'.$buyer_order->buyer_id) }}">{{ $buyer_order->buyer->first_name }} {{ $buyer_order->buyer->last_name }}</a></td>
                    <td>@if($buyer_order->cancelled) Yes @else No @endif</td>
                    <td>{{ \App\Helpers\DateTime::showDatetime($buyer_order->scheduled_delivery_time) }}</td>
                    <td>{{ \App\Helpers\DateTime::showDatetime($buyer_order->time_delivered) }}</td>
                    <td>{{ $buyer_order->created_at }}</td>
                    <td><a href="{{ url('admin/order/buyer/' . $buyer_order->id) }}"><span class="glyphicon glyphicon-eye-open"></span></a></td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {!! $buyer_orders->appends($pagination_params)->render() !!}
@endsection
