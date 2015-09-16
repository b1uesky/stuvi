$(document).ready(function() {
    $('#delete-buyer-order').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var buyerOrderId = button.data('buyer-order-id');

        var modal = $(this);
        modal.find('.cancel-order-btn').attr('href', '/order/buyer/cancel/' + buyerOrderId);
    });
});