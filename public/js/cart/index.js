/**
 * Created by nlouie on 8/13/15.
 */

$(document).ready(function () {
    $(".remove-cart-item").click(function () {
        var tr = $(this).parent('td').parent('tr');

        $.ajax({
            url: location.protocol + '//' + document.domain + '/cart/rmv',
            dataType: 'json',
            data: {
                product_id: tr.attr("value")
            },
            success: function (data) {
                console.log(data);
                if (data['removed']) {
                    // decrement cart quantity by 1
                    var num_items = data['num_items'];

                    $('.cart-quantity').text(num_items);

                    if (num_items == 0) {
                        $('.cart-quantity').addClass('hide');

                        var emptyMessage = '<div class="cart-empty text-center text-muted">' +
                            '<h2>Your shopping cart is empty.</h2>' +
                            '</div>';

                        $('.shopping-cart').html(emptyMessage);
                    } else {
                        tr.remove();
                        $(".subtotal").text('$'.concat(data['subtotal']));
                    }
                }
            }
        });
    });
});
