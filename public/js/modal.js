/**
 * Created by kingdido999 on 9/23/15.
 */

$(document).ready(function() {
    $('#delete-product').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var productId = button.data('product-id');
        var bookTitle = button.data('book-title');

        var modal = $(this);
        modal.find('input[name=id]').val(productId);
        modal.find('.book-title').text(bookTitle);
    });

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
    });

    $('#cancel-buyer-order').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var buyerOrderId = button.data('buyer-order-id');

        var modal = $(this);
        modal.find('.cancel-order-btn').attr('href', '/order/buyer/cancel/' + buyerOrderId);
    });

    $('#cancel-seller-order').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal

        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        modal.find('input[name=seller_order_id]').val(button.data('seller_order_id'))
    });
});