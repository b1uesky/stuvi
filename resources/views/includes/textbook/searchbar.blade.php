<li>
    <form action="/textbook/buy/search" method="get" class="navbar-form" role="search">
        <div class="input-group">
            <input type="text" class="form-control" id="autocomplete" name="query" placeholder="Search" value="{{ Input::get('query') }}">

            <div class="input-group-btn">
                <button class="btn list-search-btn" type="submit">
                    <i class="fa fa-search search-icon"></i>
                </button>
            </div>
        </div>
    </form>
</li>