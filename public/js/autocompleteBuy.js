$(document).ready(function() {
    $('#autocompleteBuy').autocomplete({
        source: "buy/searchAutoComplete",
        minLength: 3,
        focus: function(event, ui) {
            // prevent updating input
            event.preventDefault();
        },
        select: function(event, ui) {
            // prevent updating input
            event.preventDefault();
            // go to the book's url
            window.location.href = "/textbook/buy/" + ui.item.id;
        }
    }).autocomplete('instance')._renderItem = function(ul, item) {
        return $("<li>")
            .append(
                '<div class="autocomplete-result">' +
                    '<div class="autocomplete-thumbnail">' +
                        '<img src="' + item.image + '">' +
                    '</div>' +
                    '<div class="autocomplete-data">' +
                        '<div class="autocomplete-title">' + item.title + '</div>' +
                        '<div class="autocomplete-authors">' + item.authors.join(', ') + '</div>' +
                        '<div class="autocomplete-isbn">ISBN-10:' + item.isbn10 + '</div>' +
                        '<div class="autocomplete-isbn">ISBN-13:' + item.isbn13 + '</div>' +
                    '</div>' +
                '</div>')
            .appendTo(ul);
    };;
});