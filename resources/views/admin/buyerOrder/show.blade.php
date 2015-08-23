@extends('layouts.admin')

@section('title', 'Buyer Order')

@section('content')

    <h1>Buyer Order Detail</h1>

    <p><strong>Overview</strong></p>
    <table class="table table-hover">
        <tr>
            <th>ID</th>
            <td>{{ $buyer_order->id }}</td>
        </tr>
        <tr>
            <th>Buyer ID</th>
            <td><a href="{{ url('admin/user/'.$buyer_order->buyer_id) }}">{{ $buyer_order->buyer->first_name }} {{ $buyer_order->buyer->last_name }}</a></td>
        </tr>
        <tr>
            <th>Cancelled</th>
            <td>{{ $buyer_order->cancelled }}
                @if ($buyer_order->cancelled)
                    @ {{ $buyer_order->cancelled_time }}
                @endif
            </td>
        </tr>
        <tr>
            <th>Shipping Address</th>
            <td>{{ $buyer_order->shipping_address->addressee }}<br>
                {{ $buyer_order->shipping_address->address_line1 }} {{ $buyer_order->shipping_address->address_line2 }}<br>
                {{ $buyer_order->shipping_address->city }}, {{ $buyer_order->shipping_address->state_a2 }} {{ $buyer_order->shipping_address->zip }}<br>
                P: {{ $buyer_order->shipping_address->phone_number }}
            </td>
        </tr>
        <tr>
            <th>Courier</th>
            <td>
                @if ($buyer_order->courier)
                    <a href="{{ url('admin/user/'.$buyer_order->courier_id) }}">{{ $buyer_order->courier->first_name }} {{ $buyer_order->courier->last_name }}
                    </a>
                @endif
            </td>
        </tr>
        <tr>
            <th>Delivered Time</th>
            <td>{{ $buyer_order->time_delivered }}</td>
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

    <p><strong>Payment</strong></p>
    <table class="table table-hover">
        <tr>
            <th>Fee</th>
            <th>Discount</th>
            <th>Tax</th>
            <th>Total</th>
        </tr>
        <tr>
            <td>{{ \App\Helpers\Price::convertIntegerToDecimal($buyer_order->fee) }}</td>
            <td>- {{ \App\Helpers\Price::convertIntegerToDecimal($buyer_order->discount) }}</td>
            <td>{{ \App\Helpers\Price::convertIntegerToDecimal($buyer_order->tax) }}</td>
            <td>{{ \App\Helpers\Price::convertIntegerToDecimal($buyer_order->amount) }}</td>
        </tr>
    </table>

    <p><strong>Refund</strong></p>
    <table>
        {{--@if ($buyer_order->isRefundable())--}}
        {{--<form action="{{ url('admin/order/buyer/refund') }}" method="POST">--}}
        {{--<input type="hidden" name="_token" value="{{ csrf_token() }}">--}}
        {{--<input type="hidden" name="buyer_order_id" value="{{ $buyer_order->id }}">--}}
        {{-- refund amount --}}
        {{--<div class="form-group">--}}
        {{--<label>$</label>--}}
        {{--<input type="number" step="0.01" name="refund_amount" value="{{ $buyer_order->refundableAmount()/100 }}">--}}
        {{--<input type="submit" name="submit" class="btn" value="Refund"/>--}}
        {{--</div>--}}

        {{--</form>--}}
        {{--@endif--}}

        {{--<tr>--}}
        {{--<td>--}}
        {{--@foreach($buyer_order->stripeRefunds as $refund)--}}
        {{--<p>${{ $refund->amount/100 }} @ {{ $refund->created_at }}</p>--}}
        {{--@endforeach--}}
        {{--</td>--}}
        {{--</tr>--}}
    </table>


@endsection
