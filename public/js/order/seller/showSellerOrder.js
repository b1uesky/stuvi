/**
 * Created by nlouie on 6/16/15.
 */

$(document).ready(function() {
    // Date time picker
    // http://xdsoft.net/jqplugins/datetimepicker/
    $('#datetimepicker').datetimepicker({
        format: 'Y-m-d G:i', // config/app datetime_format
        minDate:'-1970/01/01',//yesterday is minimum date(for today use 0 or -1970/01/01)
        maxDate:'+1970/01/08', // must schedule within 7 days
        minTime: 0,
        //mask:true, // '9999/19/39 29:59' - digit is the maximum possible for a cell
        lang: 'en',
        step: 30
    });

    // Ajax: schedule pickup time
    $('#schedule-pickup-time').submit(function(e) {
        e.preventDefault();

        $.ajax({
            type: 'POST',
            url: '/order/seller/schedulePickupTime',
            data: {
                _token: $('[name="csrf_token"]').attr('content'),
                seller_order_id: $('input[name=seller_order_id]').val(),
                scheduled_pickup_time: $('#datetimepicker').val()
            },
            dataType: 'json',
            success: function(data, status) {
                $('.text-scheduled-pickup-time').text('Scheduled pickup time: ' + data['scheduled_pickup_time']);
            },
            error: function(xhr, status, errorThrown) {
                console.log(status);
                console.log(errorThrown);
            },
            complete: function(xhr, status) {
                //alert('complete!');
            }
        });
    });
});

function setFocusToTextBox(){
    document.getElementById("datetimepicker").focus();
}