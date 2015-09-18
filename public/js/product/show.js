/**
 * Created by Desmond on 8/20/15.
 */

$(document).ready(function(){

    // product delete modal
    $('#delete-product').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var productId = button.data('product-id');
        var bookTitle = button.data('book-title');

        var modal = $(this);
        modal.find('input[name=id]').val(productId);
        modal.find('.book-title').text(bookTitle);
    });
});