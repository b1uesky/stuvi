@extends('admin')

@section('title', 'User')

@section('content')
<table class="table table-hover">
    <tr>
        <th>ID</th>
        <th>Email</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Phone Number</th>
        <th>Activated</th>
        <th>Role</th>
        <th>Created At</th>
        <th>Actions</th>
    </tr>

    @foreach($users as $user)
        <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->first_name }}</td>
            <td>{{ $user->last_name }}</td>
            <td>{{ $user->phone_number }}</td>
            <td>{{ $user->isActivated2() }}</td>
            <td>{{ $user->role }}</td>
            <td>{{ $user->created_at }}</td>
            <td><a class="btn btn-info" role="button" href="{{ URL::to('admin/user/' . $user->id) }}">Details</a></td>
        </tr>
    @endforeach
</table>
@endsection
