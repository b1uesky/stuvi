/**
 * Created by Desmond on 8/7/15.
 *
 * Navbar search.
 */


$('#autocomplete').focus(function() {
    if(screen.width > 767){
        $(this).animate({
            width: '+=300px'
        });
    }

    $(this).attr('placeholder', 'Enter the textbook ISBN, Title, or Author');
});

$('#autocomplete').blur(function() {
    if(screen.width > 767){
        $(this).animate({
            width: '-=300px'
        });
    }

    $(this).attr('placeholder', 'Search');
});