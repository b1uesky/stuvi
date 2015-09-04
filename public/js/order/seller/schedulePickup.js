/**
 * Created by Desmond on 9/3/15.
 */

$(document).ready(function() {
    $('#datetimepicker').datetimepicker({
        inline: true,
        sideBySide: true
    });

    // fill in edit address modal
    $('#edit-address').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal

        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        modal.find('input[name=address_id]').val(button.data('address_id'))
        modal.find('input[name=addressee]').val(button.data('addressee'))
        modal.find('input[name=address_line1]').val(button.data('address_line1'))
        modal.find('input[name=address_line2]').val(button.data('address_line2'))
        modal.find('input[name=city]').val(button.data('city'))
        modal.find('input[name=state_a2]').val(button.data('state_a2'))
        modal.find('input[name=zip]').val(button.data('zip'))
        modal.find('input[name=phone_number]').val(button.data('phone_number'))
    })
});

// update scheduled pickup time when changing the datetimepicker
$(document).on('dp.change', function(e) {
    $('input[name=scheduled_pickup_time]').val(e.date.format('M/D/YYYY hh:mm A'));
});