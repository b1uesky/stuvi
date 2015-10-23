/**
 * Created by Desmond on 9/3/15.
 *
 * https://eonasdan.github.io/bootstrap-datetimepicker/
 */

$(document).ready(function() {
    // pickup
    var scheduled_pickup_time = $('input[name=scheduled_pickup_time]').val();

    // if pickup time not scheduled
    if (scheduled_pickup_time == '' || scheduled_pickup_time == null) {
        scheduled_pickup_time = moment().add(2, 'h');
    }

    var enabledDates = [moment(), moment().add(1, 'd')];
    var enabledHours = [];

    for (var i = 9; i <= 24; i++) {
        enabledHours.push(i);
    }

    // seller order
    $('#datetimepicker-pickup-time').datetimepicker({
        inline: true,
        sideBySide: true,
        stepping: 15,
        defaultDate: scheduled_pickup_time,
        enabledDates: enabledDates,
        enabledHours: enabledHours
    });

    // donation
    $('#datetimepicker-donation-pickup-time').datetimepicker({
        inline: true,
        sideBySide: true,
        stepping: 15,
        defaultDate: scheduled_pickup_time,
        minDate: moment(),
        enabledHours: enabledHours
    });

    // delivery
    var scheduled_delivery_time = $('input[name=scheduled_delivery_time]').val();

    // if delivery time not scheduled
    if (scheduled_delivery_time == '' || scheduled_delivery_time == null) {
        scheduled_delivery_time = moment().add(2, 'h');
    }

    // buyer order
    $('#datetimepicker-delivery-time').datetimepicker({
        inline: true,
        sideBySide: true,
        stepping: 15,
        defaultDate: scheduled_delivery_time,
        minDate: moment(),
        enabledHours: enabledHours
    });
});

// update scheduled pickup time when changing the datetimepicker
$(document).on('dp.change', function(e) {
    $('input[name=scheduled_pickup_time]').val(e.date.format('M/D/YYYY hh:mm A'));
    $('input[name=scheduled_delivery_time]').val(e.date.format('M/D/YYYY hh:mm A'));
});