/**
 * Created by Desmond on 8/7/15.
 *
 * Navbar search.
 */


$('#autocomplete').focus(function() {
    $(this).animate({
        width: '+=300px'
    });

    $(this).attr('placeholder', 'Enter the textbook ISBN, Title, or Author');
});

$('#autocomplete').blur(function() {
    $(this).animate({
        width: '-=300px'
    });

    $(this).attr('placeholder', 'Search');
});