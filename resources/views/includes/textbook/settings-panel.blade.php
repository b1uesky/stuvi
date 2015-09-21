<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Personal Settings</h3>
    </div>

    <div class="list-group">
        <a class="list-group-item {{ Request::path() == 'user/profile' ? 'active' : '' }}" href="{{ url('user/profile') }}">Profile Settings</a>
        <a class="list-group-item {{ Request::path() == 'user/account' ? 'active' : '' }}" href="{{ url('user/account') }}">Account Settings</a>
        <a class="list-group-item {{ Request::path() == 'user/email' ? 'active' : '' }}" href="{{ url('user/email') }}">Email Settings</a>
        <a class="list-group-item {{ Request::path() == 'user/bookshelf' ? 'active' : '' }}" href="{{ url('user/bookshelf') }}">Bookshelf</a>
    </div>
</div>