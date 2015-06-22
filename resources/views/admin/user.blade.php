@extends('admin')

@section('content')
    <div class="container">
        <div class="row">
            <table style="width:100%" border="1">
                <caption>Users</caption>
                <tr>
                    <th>Email</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Phone Number</th>
                    <th>Activated</th>
                </tr>

                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->first_name }}</td>
                        <td>{{ $user->last_name }}</td>
                        <td>{{ $user->phone_number }}</td>
                        <td>{{ $user->activated }}</td>
                    </tr>
                @endforeach

            </table>
        </div>
    </div>
@endsection