$(document).ready(function() {
    $('#autocompleteBuy').autocomplete({
        source: "textbook/buy/searchAutoComplete",
        minLength: 3,
        focus: function(event, ui) {
            // prevent updating input
            event.preventDefault();
        },
        select: function(event, ui) {
            // prevent updating input
            event.preventDefault();
            // go to the book's url
            window.location.href = "/textbook/buy/textbook/" + ui.item.id;
        }
    });
});