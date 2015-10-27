@extends('layouts.admin')

@section('title', 'Donation')

@section('content')

    <table class="table table-condensed" data-sortable>
        <thead>
        <tr class="active">
            <th>ID</th>
            <th>Donator</th>
            <th>Quantity</th>
            <th>Scheduled pickup time</th>
            <th>Pickup time</th>
            <th>Created at</th>
            <th>Actions</th>
        </tr>
        </thead>

        <tbody>
        @foreach($donations as $donation)
            <tr>
                <td>{{ $donation->id }}</td>
                <td><a href="{{ url('admin/user/'.$donation->user_id) }}">{{ $donation->donator->first_name }} {{ $donation->donator->last_name }}</a></td>
                <td>{{ $donation->quantity }}</td>
                <td>{{ $donation->scheduled_pickup_time }}</td>
                <td>{{ $donation->pickup_time }}</td>
                <td>{{ $donation->created_at }}</td>
                <td><a href="{{ url('admin/donation/' . $donation->id) }}"><span class="glyphicon glyphicon-eye-open"></span></a></td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {!! $donations->appends($pagination_params)->render() !!}
@endsection
