@extends('layouts.admin')

@section('title', 'Donation')

@section('content')

    <table class="table table-condensed">
        <caption>Details</caption>

        <tr>
            <th>ID</th>
            <td>{{ $donation->id }}</td>
        </tr>
        <tr>
            <th>Donator</th>
            <td><a href="{{ url('admin/donation/'.$donation->user_id) }}">{{ $donation->donator->first_name }} {{ $donation->donator->last_name }}</a></td>
        </tr>
        <tr>
            <th>Quantity</th>
            <td>{{ $donation->quantity }}</td>
        </tr>
        <tr>
            <th>Courier</th>
            <td>
                @if ($donation->courier)
                    <a href="{{ url('admin/donation/'.$donation->courier_id) }}">{{ $donation->courier->first_name }} {{ $donation->courier->last_name }}
                    </a>
                @endif
            </td>
        </tr>
        <tr>
            <th>Scheduled pickup time</th>
            <td>{{ \App\Helpers\DateTime::showDatetime($donation->scheduled_pickup_time) }}</td>
        </tr>
        <tr>
            <th>Pickup time</th>
            <td>{{ \App\Helpers\DateTime::showDatetime($donation->pickup_time) }}</td>
        </tr>
        <tr>
            <th>Created At</th>
            <td>{{ $donation->created_at }}</td>
        </tr>
        <tr>
            <th>Updated At</th>
            <td>{{ $donation->updated_at }}</td>
        </tr>
    </table>

@endsection
