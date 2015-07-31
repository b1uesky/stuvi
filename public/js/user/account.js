$(document).ready(function(){
    // side bar active style
    $('.active').removeClass('active');
    $('#side-account-link').addClass('active');
    $('#edit-btn').addClass('hidden');

    // format phone number
    $(".phone_number").mask("(999) 999-9999");
});