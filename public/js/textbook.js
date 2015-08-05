$(document).ready(function(){

    // SELL SEARCH BUTTON FIX
    // original problem - the search button was pushed down whenever there was an isbn input error

    // adds 31px margin-bottom when there is an error
    $('#form-isbn').submit(function () {
        if ($('#textbook-search').hasClass('has-error')) {
            //alert('has-error');
            $('.search-btn').addClass('search-btn-fix');
        }
    });

    // remove the extra margin - button stays in normal starting position
    // the backspace key is not included in the jQuery keypress() function
    $('#textbook-search').keypress(function () {
        $('.search-btn').removeClass('search-btn-fix');
    });

    // this code is for the backspace key (keyCode 8)
    $('#textbook-search').keydown(function (e) {
        if (e.keyCode == 8) {
            $('.search-btn').removeClass('search-btn-fix');
        }
    });


});