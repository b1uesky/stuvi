@extends('layouts.admin')

@section('title', 'Contact')

@section('content')

    <h1>Contact Detail</h1>
    
    <table class="table table-hover">
        <tr>
            <th>ID</th>
            <td>{{ $contact->id }}</td>
        </tr>
        <tr>
            <th>Created At</th>
            <td>{{ $contact->created_at }}</td>
        </tr>
        <tr>
            <th>Replied</th>
            <td>{{ $contact->isReplied() }}</td>
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
    </table>

    @if($contact->is_replied == false)
        <div class="contact-response">
            <form action="/admin/contact/reply" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="contact_id" value="{{ $contact->id }}">

                <div class="form-group">
                    <textarea class="form-control" rows="8" name="response" placeholder="Reply..."></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    @endif

@endsection
