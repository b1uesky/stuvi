<form action="/textbook/search" method="get">
    <input type="hidden" name="university_id" value="1">

    <div class="input-group">
        <input type="text" name="query" id="autocomplete" class="form-control input-lg" placeholder="Enter the textbook ISBN, Title, or Author"/>

        <div class="input-group-btn">
            <button class="btn btn-default btn-lg btn-inline-search" type="submit">
                <span class="glyphicon glyphicon-search"></span>
            </button>
        </div>
    </div>
</form>