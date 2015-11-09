<div class="searchbar default-searchbar">
    <form action="/textbook/search" method="get">
        <div class="searchbar-input-container searchbar-input-container-query">
            <input type="hidden" name="university_id" value="1">
            <input type="text" name="query" id="autocomplete"
                   class="form-control searchbar-input searchbar-input-query"
                   placeholder="Enter the textbook ISBN, Title, or Author"/>
        </div>

        {{--Show school selection if it's a guest--}}
        {{--@if(Auth::guest())--}}
            {{--<div class="searchbar-input-container searchbar-input-container-university">--}}
                {{--<label class="sr-only" for="uni_id">University</label>--}}
                {{--<select name="university_id" class="form-control searchbar-input searchbar-input-university selectpicker"--}}
                        {{--id="uni_id">--}}
                    {{--@foreach(\App\University::where('is_public', true)->get() as $university)--}}
                        {{--<option value="{{ $university->id }}">{{ $university->abbreviation }}</option>--}}
                    {{--@endforeach--}}
                {{--</select>--}}
            {{--</div>--}}
        {{--@endif--}}

        <div class="searchbar-input-container searchbar-input-container-submit default-guest-search-submit">
            <input class="btn btn-primary btn-search" type="submit" value="Search">
        </div>
    </form>
</div>