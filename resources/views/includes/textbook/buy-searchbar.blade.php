<div class="searchbar default-searchbar">
    <form action="/textbook/buy/search" method="get">
        <div class="searchbar-input-container searchbar-input-container-query">
            <input type="text" name="query" id="autocomplete"
                   class="form-control searchbar-input searchbar-input-query"
                   placeholder="Enter the textbook ISBN, Title, or Author"/>
        </div>

        {{--Show school selection if it's a guest--}}
        @if(Auth::guest())
            <div class="searchbar-input-container searchbar-input-container-university">
                <label class="sr-only" for="uni_id">University</label>
                <select name="university_id" class="form-control searchbar-input searchbar-input-university selectpicker"
                        id="uni_id">
                    @foreach(\App\University::where('is_public', true)->get() as $university)
                        <option value="{{ $university->id }}">{{ $university->abbreviation }}</option>
                    @endforeach
                </select>
            </div>
        @endif

        <div class="searchbar-input-container searchbar-input-container-submit default-guest-search-submit">
            <input class="btn btn-primary btn-search" type="submit" value="Search">
        </div>
    </form>
</div>

{{-- Hidden by default, show on small screen --}}
<div class="xs-guest-search-bar">
    <form action="/textbook/buy/search" method="get">
        <div class="xs-guest-search-bar-input">
            <label class="sr-only" for="autocompleteBuy">Search for Textbooks by ISBN, Title or Author</label>
            <input type="text" name="query" id="autocompleteBuy"
                   class="form-control searchbar-input"
                   placeholder="Enter the textbook ISBN, Title, or Author"/>
        </div>
        @if(Auth::guest())
            {{-- Show school selection if it's a guest --}}
            <div class="xs-guest-search-bar-input-uni">
                <label class="sr-only">University ID</label>
                <select name="university_id" class="form-control selectpicker searchbar-input searchbar-input-university-with-border">
                    @foreach($universities as $university)
                        <option value="{{ $university->id }}">{{ $university->abbreviation }}</option>
                    @endforeach
                </select>
            </div>
        @endif
        <div class="xs-guest-search-bar-input-submit">
            <button class="btn btn-primary btn-lg btn-block" type="submit" value="Search">
                Search
            </button>
        </div>
    </form>
</div>