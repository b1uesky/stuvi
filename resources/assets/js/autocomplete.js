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
                        term: request.term
                    },
                    success: function (data) {
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
                // go to book confirmation page
                window.location.href = "/textbook/confirm/" + ui.item.id + "?query=" + this.value;
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

            // use default image if no image.
            var image = 'https://s3.amazonaws.com/stuvi-icon/picture_128.png';

            if (item.image) {
                image = 'https://s3.amazonaws.com/stuvi-book-img/' + item.image;
            }

            var authors = 'Unknown';

            if (item.authors && item.authors.length > 0) {
                authors = item.authors.join(', ');
            }

            var highlightedTitle = highlightTerm(item.title, this.term);
            var highlightedAuthors = highlightTerm(authors, this.term);
            var highlightedISBN10 = highlightTerm(item.isbn10, this.term);
            var highlightedISBN13 = highlightTerm(item.isbn13, this.term);

            return $("<li>")
                .append(
                '<div class="autocomplete-result">' +
                '<div class="autocomplete-thumbnail">' +
                '<img src="' + image + '">' +
                '</div>' +
                '<div class="autocomplete-data">' +
                '<div class="autocomplete-title"><h4>' + highlightedTitle + '</h4></div>' +
                '<div class="autocomplete-authors">' + highlightedAuthors + '</div>' +
                '<div class="autocomplete-isbn">ISBN-10: ' + highlightedISBN10 + '</div>' +
                '<div class="autocomplete-isbn">ISBN-13: ' + highlightedISBN13 + '</div>' +
                '</div>' +
                '</div>')
                .appendTo(ul);
    };

    // highlight term in the matching text
    function highlightTerm(text, term) {
        return String(text).replace(
            new RegExp(term, 'gi'),
            "<span class='text-bold text-highlight'>$&</span>"
        );
    }

    // navbar search expand/shrink
    //$('.navbar-form #autocomplete').focus(function() {
    //    if(screen.width > 767){
    //        $(this).animate({
    //            width: '+=300px'
    //        });
    //    }
    //
    //    $(this).attr('placeholder', 'Enter the textbook ISBN, Title, or Author');
    //});
    //
    //$('.navbar-form #autocomplete').blur(function() {
    //    if(screen.width > 767){
    //        $(this).animate({
    //            width: '-=300px'
    //        });
    //    }
    //
    //    $(this).attr('placeholder', 'Search');
    //});
});