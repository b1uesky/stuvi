@extends('layouts.admin')

@section('title', 'Seller Order')

@section('content')

    <form class="form-inline" role="form" action="{{ url('admin/order/seller') }}" method="get">
        <div class="form-group">
            <select name="filter" class="form-control">
                <option value="id" @if ($pagination_params['filter'] == 'id') selected @endif>ID</option>
                <option value="title" @if ($pagination_params['filter'] == 'title') selected @endif>Title</option>
                <option value="seller" @if ($pagination_params['filter'] == 'seller') selected @endif>Seller</option>
            </select>
        </div> <!-- form group [rows] -->
        <div class="form-group">
            <input type="text" class="form-control input-large" name="keyword" value="{{ $pagination_params['keyword'] }}">
        </div><!-- form group [search] -->
        <div class="form-group">
            <label class="filter-col" style="margin-right:0;">Order by:</label>
            <select name="order_by" class="form-control">
                <option value="id" @if ($pagination_params['order_by'] == 'id') selected @endif>ID</option>
                <option value="title" @if ($pagination_params['order_by'] == 'title') selected @endif>Title</option>
                <option value="first_name" @if ($pagination_params['order_by'] == 'first_name') selected @endif>Seller First Name</option>
                <option value="last_name" @if ($pagination_params['order_by'] == 'last_name') selected @endif>Seller Last Name</option>
                <option value="scheduled_pickup_time" @if ($pagination_params['order_by'] == 'scheduled_pickup_time') selected @endif>Scheduled Pickup Time</option>
                <option value="pickup_time" @if ($pagination_params['order_by'] == 'pickup_time') selected @endif>Pickup Time</option>
                <option value="created_at" @if ($pagination_params['order_by'] == 'created_at') selected @endif>Created At</option>
                <option value="updated_at" @if ($pagination_params['order_by'] == 'updated_at') selected @endif>Updated At</option>
            </select>
        </div> <!-- form group [rows] -->
        <div class="form-group">
            <select name="order" class="form-control">
                <option value="DESC" @if ($pagination_params['order'] == 'DESC') selected @endif>DESC</option>
                <option value="ASC" @if ($pagination_params['order'] == 'ASC') selected @endif>ASC</option>
            </select>
        </div> <!-- form group [rows] -->
        <div class="form-group">
            <button type="submit" class="btn btn-default filter-col">
                Search
            </button>
        </div>
    </form>

    <br>

    <table class="table table-hover">
        <tr>
            <th>ID</th>
            <th>Product</th>
            <th>Seller</th>
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
                <td><a href="{{ url('admin/user/'.$seller_order->seller()->id) }}">{{ $seller_order->seller()->first_name.' '.$seller_order->seller()->last_name }}</a></td>
                <td>@if($seller_order->cancelled) Yes @else No @endif</td>
                <td>{{ $seller_order->scheduled_pickup_time }}</td>
                <td>{{ $seller_order->pickup_time }}</td>
                <td>{{ $seller_order->created_at }}</td>
                <td><a class="btn btn-primary btn-block" role="button" href="{{ URL::to('admin/order/seller/' . $seller_order->id) }}">Details</a></td>
            </tr>
        @endforeach
    </table>

    {!! $seller_orders->appends($pagination_params)->render() !!}
@endsection
