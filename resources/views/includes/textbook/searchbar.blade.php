<li>
    <form action="{{ url('textbook/search') }}" method="get" role="search" class="navbar-form navbar-left" id="searchbar-form">
        @if(Auth::guest())
            <input type="hidden" name="university_id" value="{{ Input::get('university_id') }}">
        @endif

        <div class="input-group">
            <input type="text" class="form-control" id="autocomplete" name="query" placeholder="Search" value="{{ Input::get('query') }}">

            <div class="input-group-btn">
                <button class="btn btn-default btn-inline-search" type="submit">
                    <span class="glyphicon glyphicon-search"></span>
                </button>
            </div>
        </div>
    </form>
</li>