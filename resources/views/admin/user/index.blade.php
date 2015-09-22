@extends('layouts.admin')

@section('title', 'User')

@section('content')

    <form class="form-inline" role="form" action="{{ url('admin/user') }}" method="get">
        <div class="form-group">
            <select name="filter" class="form-control">
                <option value="id" @if ($pagination_params['filter'] == 'id') selected @endif>ID</option>
                <option value="name" @if ($pagination_params['filter'] == 'name') selected @endif>Name</option>
                <option value="phone" @if ($pagination_params['filter'] == 'phone') selected @endif>Phone</option>
                <option value="role" @if ($pagination_params['filter'] == 'role') selected @endif>Role</option>
            </select>
        </div> <!-- form group [rows] -->
        <div class="form-group">
            <input type="text" class="form-control input-large" name="keyword" value="{{ $pagination_params['keyword'] }}">
        </div><!-- form group [search] -->
        <div class="form-group">
            <button type="submit" class="btn btn-default filter-col">
                Search
            </button>
        </div>
    </form>

    <br>

    <table class="table table-condensed" data-sortable>
        <thead>
            <tr class="active">
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Phone Number</th>
                <th>Activated</th>
                <th>Role</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->first_name }}</td>
                    <td>{{ $user->last_name }}</td>
                    <td>{{ $user->phone_number }}</td>
                    <td>{{ $user->isActivatedToStr() }}</td>
                    <td>{{ $user->role }}</td>
                    <td>{{ $user->created_at }}</td>
                    <td><a class="btn btn-primary btn-block" role="button" href="{{ url('admin/user/' . $user->id) }}">Details</a></td>
                </tr>
            @endforeach
        </tbody>

    </table>

    {!! $users->appends($pagination_params)->render() !!}
@endsection
