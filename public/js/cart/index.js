/**
 * Created by nlouie on 8/13/15.
 */
/*
function goBack() {
    window.history.back();
}
*/

$(document).ready(function () {
    $(".remove-cart-item").click(function () {
        var tr = $(this).parent('td').parent('tr');
        $(this).parent('td').html('<a class="fa fa-spinner fa-pulse fa-1x loading"></a>');

        $.ajax({
            url: location.protocol + '//' + document.domain + '/cart/rmv',
            dataType: 'json',
            data: {
                product_id: tr.attr("value")
            },
            success: function (data) {
                console.log(data);
                if (data['removed']) {
                    if (data['num_items'] == 0) {
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
