<li>
    <form action="/textbook/buy/search" method="get" class="navbar-form" role="search">
        <div class="input-group">
            <input type="text" class="form-control" id="autocomplete" name="query" placeholder="Search" value="{{ Input::get('query') }}">
            @if(Auth::guest())
                <input type="hidden" name="university_id" value="{{ Input::get('university_id') }}">
            @endif

            <div class="input-group-btn">
                <button class="btn btn-primary" type="submit">
                    <i class="fa fa-search search-icon"></i>
                </button>
            </div>
        </div>
    </form>
</li>