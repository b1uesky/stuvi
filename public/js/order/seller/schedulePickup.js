/**
 * Created by Desmond on 9/3/15.
 *
 * https://eonasdan.github.io/bootstrap-datetimepicker/
 */

$(document).ready(function() {
    var scheduled_pickup_time = $('input[name=scheduled_pickup_time]').val();

    // if pickup time not scheduled, use current time plus 2 hours
    if (scheduled_pickup_time == '' || scheduled_pickup_time == null) {
        scheduled_pickup_time = moment().add(2, 'h');
    }

    var enabledDates = [moment(), moment().add(1, 'd')];
    var enabledHours = [];

    for (var i = 9; i <= 24; i++) {
        enabledHours.push(i);
    }

    $('#datetimepicker').datetimepicker({
        inline: true,
        sideBySide: true,
        stepping: 15,
        defaultDate: scheduled_pickup_time,
        enabledDates: enabledDates,
        enabledHours: enabledHours
    });
});

// update scheduled pickup time when changing the datetimepicker
$(document).on('dp.change', function(e) {
    $('input[name=scheduled_pickup_time]').val(e.date.format('M/D/YYYY hh:mm A'));
});