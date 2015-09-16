/**
 * jQuery UI AutoComplete for textbook search
 * http://api.jqueryui.com/autocomplete/#option-source
 */

$(document).ready(function () {
    var closing = false;

    $('#autocomplete')
        .autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: location.protocol + '//' + document.domain + '/textbook/searchAutoComplete',
                    dataType: 'json',
                    data: {
                        term: request.term,
                        university_id: $('.search-input-university').val()
                    },
                    success: function (data) {
                        console.log(data);
                        response(data);
                    }
                })
            },
            minLength: 3,
            focus: function (event, ui) {
                // prevent updating input
                event.preventDefault();
            },
            select: function (event, ui) {
                // prevent updating input
                event.preventDefault();
                // go to the book's url
                window.location.href = "/textbook/buy/" + ui.item.id + "?query=" + this.value;
            },
            close: function()
            {
                // avoid double-pop-up issue
                closing = true;
                setTimeout(function() { closing = false; }, 300);
            }
        })
        .focus(function() {
            if (!closing) {
                $(this).autocomplete('search');
            }
        })
        .autocomplete('instance')._renderItem = function (ul, item) {
        // TODO: use default image if no image.
        var image = 'https://s3.amazonaws.com/stuvi-book-img/placeholder.png';

        if (item.image) {
            image = 'https://s3.amazonaws.com/stuvi-book-img/' + item.image;
        }

        var authors = 'Unknown';

        if (item.authors && item.authors.length > 0) {
            authors = item.authors.join(', ');
        }

        return $("<li>")
            .append(
            '<div class="autocomplete-result">' +
            '<div class="autocomplete-thumbnail">' +
            '<img src="' + image + '">' +
            '</div>' +
            '<div class="autocomplete-data">' +
            '<div class="autocomplete-title"><h4>' + item.title + '</h4></div>' +
            '<div class="autocomplete-authors">' + authors + '</div>' +
            '<div class="autocomplete-isbn">ISBN-10:' + item.isbn10 + '</div>' +
            '<div class="autocomplete-isbn">ISBN-13:' + item.isbn13 + '</div>' +
            '</div>' +
            '</div>')
            .appendTo(ul);
    };
    ;
});