@extends('admin')

@section('title', 'Contact')

@section('content')

    <table class="table table-hover">
        <tr>
            <th>ID</th>
            <td>{{ $contact->id }}</td>
        </tr>
        <tr>
            <th>Name</th>
            <td>{{ $contact->name }}</td>
        </tr>
        <tr>
            <th>Email</th>
            <td>{{ $contact->email }}</td>
        </tr>
        <tr>
            <th>Message</th>
            <td>{{ $contact->message }}</td>
        </tr>
        <tr>
            <th>Created At</th>
            <td>{{ $contact->created_at }}</td>
        </tr>
        <tr>
            <th>Updated At</th>
            <td>{{ $contact->updated_at }}</td>
        </tr>
    </table>

@endsection
