/**
 * Created by nlouie on 6/5/15.
 */

$(document).ready(function(){
    $('.active').removeClass('active');
    $('#side-profile-link').addClass('active');
    $('#edit-btn').addClass('hidden');

    $('#datetimepicker1').datetimepicker({
        lang:'en',
        timepicker:false,
        format:'m-d-Y'
    });

    $('#datetimepicker').datetimepicker({
        format: 'm-d-Y', // config/app datetime_format
        lang: 'en',
        timepicker:false,
        step: 30
    });
});