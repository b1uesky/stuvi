/**
 * Created by Desmond on 8/17/15.
 */

$(document).ready(function() {
    $('.add-to-cart').submit(function(e) {
        e.preventDefault();
        var submit_btn = $(this).find('input[type=submit]');

        $.ajax({
            url: location.protocol + '//' + document.domain + '/cart/add',
            type: 'POST',
            data: {
                _token: $('[name="csrf_token"]').attr('content'),
                product_id: $(this).find('input[name=product_id]').val()
            },
            dataType: 'json',
            success: function(data) {
                if (data['success']) {
                    // disable submit button
                    submit_btn.prop('disabled', true);
                    submit_btn.val('Added to cart');

                    // increment cart quantity by 1
                    var current_qty = parseInt($('.cart-quantity').text());
                    $('.cart-quantity').text(current_qty + 1);
                } else {
                    // error
                    console.log(data['message']);

                    // TODO: error message display
                }
                // $('#loader-wrapper').hide();
            },
            error: function(xhr, status, error) {
                console.log(status);
                console.log(error);
            }
        });
    });
});