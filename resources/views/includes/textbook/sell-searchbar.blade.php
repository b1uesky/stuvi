<div class="searchbar default-searchbar">
    <form action="/textbook/sell/search" method="post" id="form-isbn">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <label class="sr-only" for=""></label>
        <div class="searchbar-input-container searchbar-input-container-query form-group" id="textbook-search">
            <input type="text" name="isbn" class="form-control searchbar-input searchbar-input-query"
                   id="sell-search-input"
                   placeholder="Enter the textbook ISBN (10 or 13 digits)"/>
        </div>
        <div class="searchbar-input-container searchbar-input-container-submit form-group">
            <input class="btn btn-primary btn-search" type="submit" value="Search">
        </div>
    </form>
</div>

{{-- Hidden by default, show on small screen --}}
<div class="xs-guest-search-bar">
    <form action="/textbook/sell/search" method="post" id="form-isbn">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <div class="xs-guest-search-bar-input" id="xs-textbook-search">
            <input type="text" name="isbn" class="form-control searchbar-input"
                   id="sell-search-input"
                   placeholder="Enter the textbook ISBN (10 or 13 digits)"/>
        </div>
        <div class="xs-guest-search-bar-input-submit">
            <button class="btn btn-primary btn-lg btn-block" id="xs-sell-search-btn" type="submit"
                    name="search" value="Search"> Search
            </button>
        </div>
    </form>
</div>