$(document).ready(function() {
    $('#autocompleteBuy').autocomplete({
        source: "textbook/buy/searchAutoComplete",
        minLength: 3,
        response: function( event, ui ) {
          return ui.content;
        },
        select: function(event, ui) {
            $('#autocompleteBuy').val(ui.item.value);
        }
    });
});