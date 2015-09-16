/**
 * Created by kingdido999 on 9/16/15.
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
});