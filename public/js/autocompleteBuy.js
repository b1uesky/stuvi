$(document).ready(function() {
    $('#autocompleteBuy').autocomplete({
        serviceUrl: '/textbook/buy/search',
        type: 'POST',
        onSelect: function (suggestion) {
            alert('You selected: ' + suggestion.value + ', ' + suggestion.data);
        }
    });
});