@extends('layouts.admin')

@section('title', 'User')

@section('content')

    <form action="{{ url('admin/user/' . $user->id) }}" method="post">
        {!! csrf_field() !!}
        <input type="hidden" name="_method" value="PUT" />

        <div class="form-group">
            <label for="">First name</label>
            <input type="text" class="form-control" name="first_name" value="{{ $user->first_name }}">
        </div>

        <div class="form-group">
            <label for="">Last name</label>
            <input type="text" class="form-control" name="last_name" value="{{ $user->last_name }}">
        </div>

        <div class="form-group">
            <label for="">Phone number</label>
            <input type="text" class="form-control" name="phone_number" value="{{ $user->phone_number }}">
        </div>

        <div class="form-group">
            <label for="">University ID</label>
            <input type="text" class="form-control" name="university_id" value="{{ $user->university_id }}">
        </div>

        <div class="form-group">
            <label for="">Activated</label>
            <div class="radio">
                <label>
                    <input type="radio" name="activated" value="0" {{ $user->isActivated() ? '' : 'checked' }}> No
                </label>
            </div>

            <div class="radio">
                <label>
                    <input type="radio" name="activated" value="1" {{ $user->isActivated() ? 'checked' : '' }}> Yes
                </label>
            </div>
        </div>

        <input type="submit" value="Update" class="btn btn-primary">
    </form>

@endsection
