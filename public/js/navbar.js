/**
 * Created by Desmond on 8/7/15.
 *
 * Navbar search.
 */


$('#autocomplete').focus(function() {
    $('#autocomplete').animate({
        width: '500px'
    })
});

$('#autocomplete').blur(function() {
    $('#autocomplete').animate({
        width: '200px'
    })
});