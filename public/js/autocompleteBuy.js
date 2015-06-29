$(document).ready(function() {
    $('#autocompleteBuy').autocomplete({
        source: "textbook/buy/searchAutoComplete",
        minLength: 3,
        response: function( event, ui ) {
            return ui.content;
        },
        select: function(event, ui) {
            // go to the book's url
            window.location.href = "/textbook/buy/textbook/" + ui.item.id;
        }
    });
});