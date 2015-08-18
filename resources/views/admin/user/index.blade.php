@extends('admin')

@section('title', 'User')

@section('content')

    <h1>Users</h1>

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
            <label class="filter-col" style="margin-right:0;">Order by:</label>
            <select name="order_by" class="form-control">
                <option value="id" @if ($pagination_params['order_by'] == 'id') selected @endif>ID</option>
                <option value="first_name" @if ($pagination_params['order_by'] == 'first_name') selected @endif>First Name</option>
                <option value="last_name" @if ($pagination_params['order_by'] == 'last_name') selected @endif>Last Name</option>
                <option value="phone_number" @if ($pagination_params['order_by'] == 'phone_number') selected @endif>Phone</option>
                <option value="role" @if ($pagination_params['order_by'] == 'role') selected @endif>Role</option>
            </select>
        </div> <!-- form group [rows] -->
        <div class="form-group">
            <select name="order" class="form-control">
                <option value="DESC" @if ($pagination_params['order'] == 'DESC') selected @endif>DESC</option>
                <option value="ASC" @if ($pagination_params['order'] == 'ASC') selected @endif>ASC</option>
            </select>
        </div> <!-- form group [rows] -->
        <div class="form-group">
            <button type="submit" class="btn btn-default filter-col">
                Search
            </button>
        </div>
    </form>

    <table class="table table-hover">
        <tr>
            <th>ID</th>
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

    {!! $users->appends($pagination_params)->render() !!}
@endsection
