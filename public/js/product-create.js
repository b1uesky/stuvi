/**
 * Created by Sanam on 6/18/15.
 */

$(document).ready(function () {
    $('.condition-btn').click(function () {
        $('.active-btn').removeClass('active-btn');
        $(this).addClass('active-btn');
    });
});