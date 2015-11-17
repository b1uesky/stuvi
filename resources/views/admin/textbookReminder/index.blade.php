@extends('layouts.admin')

@section('title', 'Textbook Reminder')

@section('content')

    <table class="table table-condensed" data-sortable>
        <thead>
        <tr class="active">
            <th>ID</th>
            <th>Textbook</th>
            <th>User</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>
        </thead>

        <tbody>
        @foreach($book_reminders as $br)
            <tr>
                <td>{{ $br->id }}</td>
                <td><a href="{{ url('admin/book/' . $br->book->id) }}">{{ $br->book->title }}</a></td>
                <td><a href="{{ url('admin/user/' . $br->user->id) }}">{{ $br->user->fullName() }}</a></td>
                <td>{{ $br->user->primaryEmailAddress() }}</td>
                <td></td>
            </tr>
        @endforeach
        </tbody>

    </table>

    {!! $book_reminders->appends($pagination_params)->render() !!}
@endsection
