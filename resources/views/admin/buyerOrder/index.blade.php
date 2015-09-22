@extends('layouts.admin')

@section('title', 'Buyer Order')

@section('content')

    <form class="form-inline" role="form" action="{{ url('admin/order/buyer') }}" method="get">
        <div class="form-group">
            <select name="filter" class="form-control">
                <option value="id" @if ($pagination_params['filter'] == 'id') selected @endif>ID</option>
                <option value="buyer" @if ($pagination_params['filter'] == 'buyer') selected @endif>Buyer</option>
            </select>
        </div> <!-- form group [rows] -->
        <div class="form-group">
            <input type="text" class="form-control input-large" name="keyword" value="{{ $pagination_params['keyword'] }}">
        </div><!-- form group [search] -->
        <div class="form-group">
            <button type="submit" class="btn btn-default filter-col">
                Search
            </button>
        </div>
    </form>

    <br>

    <table class="table table-condensed" data-sortable>
        <thead>
            <tr class="active">
                <th>ID</th>
                <th>Buyer</th>
                <th>Cancelled</th>
                <th>Delivered Time</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            @foreach($buyer_orders as $buyer_order)
                <tr>
                    <td>{{ $buyer_order->id }}</td>
                    <td><a href="{{ url('admin/user/'.$buyer_order->buyer_id) }}">{{ $buyer_order->buyer->first_name }} {{ $buyer_order->buyer->last_name }}</a></td>
                    <td>@if($buyer_order->cancelled) Yes @else No @endif</td>
                    <td>{{ $buyer_order->time_delivered }}</td>
                    <td>{{ $buyer_order->created_at }}</td>
                    <td><a class="btn btn-primary btn-block" role="button" href="{{ url('admin/order/buyer/' . $buyer_order->id) }}">Details</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {!! $buyer_orders->appends($pagination_params)->render() !!}
@endsection
