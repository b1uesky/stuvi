/**
 * Created by Desmond on 9/8/15.
 */

$(document).ready(function() {

    // fill in #cancel-seller-order modal
    $('#cancel-seller-order').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal

        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        modal.find('input[name=seller_order_id]').val(button.data('seller_order_id'))
    });

});