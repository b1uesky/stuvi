$(document).ready(function() {
    var time_from_now = moment($('.product-posted-time').text()).fromNow();
    $('.product-posted-time').text(time_from_now);
});