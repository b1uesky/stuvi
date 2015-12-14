/**
 * Created by Desmond on 8/17/15.
 */

$(document).ready(function() {

    // remove a cart item
    $(".remove-cart-item").click(function () {
        var product_id = $(this).parent().parent().data("product-id");

        $.ajax({
            url: location.protocol + '//' + document.domain + '/cart/rmv',
            type: 'POST',
            dataType: 'json',
            data: {
                _token: $('[name="csrf_token"]').attr('content'),
                product_id: product_id,
            },
            success: function (data) {
                if (data['removed']) {
                    var quantity = data['quantity'];
                    updateCartQuantity(quantity);
                    removeCartItem(product_id, quantity);
                } else {
                    console.log(data['message']);
                }
            },
            error: function(xhr, status, error) {
                console.log(status);
                console.log(error);
            }
        });
    });

    // update cart quantity text
    function updateCartQuantity(quantity) {
        $('.cart-quantity').text(quantity);
    }

    // remove a cart item
    function removeCartItem(product_id, quantity) {
        if (quantity > 0) {
            // remove cart item row
            $('*[data-product-id="'+product_id+'"]').remove();

            // update subtotal
            $(".subtotal").text('$'.concat(data['subtotal']));
        } else {
            // empty cart modal
            $('#cart-popup .modal-body').html('<h4>Your cart is empty...</h4>');
            $('#cart-popup .modal-footer').remove();

            // hide cart quantity
            $('.cart-quantity').addClass('invisible');

            // empty cart index page
            $('.shopping-cart').html($('.cart-empty').html());
        }
    }

    //$('.add-to-cart').submit(function(e) {
    //    e.preventDefault();
    //    var submit_btn = $(this).find('[type=submit]');
    //
    //    $.ajax({
    //        url: location.protocol + '//' + document.domain + '/cart/add',
    //        type: 'POST',
    //        data: {
    //            _token: $('[name="csrf_token"]').attr('content'),
    //            product_id: $(this).find('input[name=product_id]').val()
    //        },
    //        dataType: 'json',
    //        success: function(data) {
    //            if (data['success']) {
    //                // disable submit button
    //                submit_btn.prop('disabled', true);
    //                submit_btn.html('Added to cart');
    //
    //                if (data['quantity'] > 0) {
    //                    $('.cart-quantity').text(data['quantity']);
    //                    $('.cart-quantity').removeClass('hide');
    //                } else {
    //                    $('.cart-quantity').addClass('hide');
    //                }
    //            } else {
    //                // error
    //                console.log(data['message']);
    //
    //                // TODO: error message display
    //            }
    //        },
    //        error: function(xhr, status, error) {
    //            console.log(status);
    //            console.log(error);
    //        }
    //    });
    //});
});