@extends('admin')

@section('title', 'Buyer Payment')

@section('content')

    <table class="table table-hover">
        <tr>
            <th>ID</th>
            <td>{{ $buyer_payment->id }}</td>
        </tr>
        <tr>
            <th>Buyer Order ID</th>
            <td><a href="{{ url('admin/buyerOrder/'.$buyer_payment->buyer_order_id) }}">{{ $buyer_payment->buyer_order_id }}</a></td>
        </tr>
        <tr>
            <th>Amount</th>
            <td>{{ $buyer_payment->amount }}</td>
        </tr>
        <tr>
            <th>Charge ID</th>
            <td>{{ $buyer_payment->charge_id }}</td>
        </tr>
        <tr>
            <th>Card ID</th>
            <td>{{ $buyer_payment->card_id }}</td>
        </tr>
        <tr>
            <th>Card Last 4</th>
            <td>{{ $buyer_payment->card_last4 }}</td>
        </tr>
        <tr>
            <th>Card Brand</th>
            <td>{{ $buyer_payment->card_brand }}</td>
        </tr>
    </table>

@endsection
