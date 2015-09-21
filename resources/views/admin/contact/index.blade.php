@extends('layouts.admin')

@section('title', 'Contact')

@section('content')

    <table class="table table-hover">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Message</th>
            <th>Created At</th>
            <th>Actions</th>
        </tr>

        @foreach($contacts as $contact)
            <tr class="{{ $contact->is_replied ? '' : 'warning' }}">
                <td>{{ $contact->id }}</td>
                <td>{{ $contact->name }}</td>
                <td>{{ $contact->email }}</td>
                <td>{{ $contact->message }}</td>
                <td>{{ $contact->created_at }}</td>
                <td><a class="btn btn-primary btn-block" role="button" href="{{ URL::to('admin/contact/' . $contact->id) }}">Details</a></td>
            </tr>
        @endforeach
    </table>

    {!! $contacts->render() !!}
@endsection
