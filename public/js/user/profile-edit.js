/**
 * Created by nlouie on 6/5/15.
 */

$(document).ready(function(){
    $('.active').removeClass('active');
    $('#side-profile-edit-link').addClass('active');
    $('#edit-btn').addClass('hidden');

    // format phone number
    $(".phone_number").mask("(999) 999-9999");

    $('#datetimepicker1').datetimepicker({
        lang:'en',
        timepicker:false,
        scrollInput:false,
        format:'m-d-Y'
    });

    $('#datetimepicker').datetimepicker({
        format: 'm-d-Y', // config/app datetime_format
        lang: 'en',
        timepicker:false,
        scrollInput:false,
        step: 30
    });
});