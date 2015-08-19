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
            <td><a href="{{ url('admin/user/'.$buyer_order->buyer_id) }}">{{ $buyer_order->buyer_id }}</a></td>
        </tr>
        <tr>
            <th>Courier ID</th>
            <td><a href="{{ url('admin/user/'.$buyer_order->courier_id) }}">{{ $buyer_order->courier_id }}</a></td>
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
            <td>{{ $buyer_order->shipping_address->address_line1 }}&nbsp;
                @if (!empty($buyer_order->shipping_address->address_line2))
                    {{ $buyer_order->shipping_address->address_line2 }}
                @endif
                &nbsp;&nbsp;{{ $buyer_order->shipping_address->city }},&nbsp;{{ $buyer_order->shipping_address->state_a2 }}&nbsp;
                {{ $buyer_order->shipping_address->zip }}
            </td>
        </tr>
        <tr>
            <th>Payment</th>
            <td><a href="#">${{ $buyer_order->amount/100 }}</a></td>
        </tr>
        <tr>
            <th>Items</th>
            <td>
            <table>
                @foreach($buyer_order->seller_orders as $seller_order)
                    <tr>
                        <a href="{{ url('admin/order/seller/'.$seller_order->id) }}">{{ $seller_order->product->book->title }}</a><br>
                    </tr>
                @endforeach
            </table>
            </td>
        </tr>
    </table>


@endsection
