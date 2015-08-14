@extends('admin')

@section('title', 'User')

@section('content')

    <table class="table table-hover">
        <tr>
            <th>ID</th>
            <td>{{ $user->id }}</td>
        </tr>
        <tr>
            <th>Email</th>
            <td><table>
                    <tr>
                        <th>Address</th>
                        <th>Verified</th>
                        <th>Primary</th>
                    </tr>
            @foreach($user->emails as $email)
                <tr>
                    <td>{{ $email->email_address }}</td>
                    <td>{{ $email->verified }}</td>
                    <td>{{ $email->isPrimary() }}</td>
                </tr>
            @endforeach
            </table></td>
        </tr>
        <tr>
            <th>First Name</th>
            <td>{{ $user->first_name }}</td>
        </tr>
        <tr>
            <th>Last Name</th>
            <td>{{ $user->last_name }}</td>
        </tr>
        <tr>
            <th>Phone Number</th>
            <td>{{ $user->phone_number }}</td>
        </tr>
        <tr>
            <th>Activated</th>
            <td>{{ $user->isActivated2() }}</td>
        </tr>
        <tr>
            <th>Role</th>
            <td>{{ $user->role }}</td>
        </tr>
        <tr>
            <th>Created At</th>
            <td>{{ $user->created_at }}</td>
        </tr>
        <tr>
            <th>Updated At</th>
            <td>{{ $user->updated_at }}</td>
        </tr>
    </table>

@endsection
