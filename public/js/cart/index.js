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
                    tr.html("<td>".concat(data['message'], "</td><td></td><td></td><td></td>"));
                    $(".fee").text('$'.concat(data['fee'] / 100));
                    $(".discount").text('- $'.concat(data['discount'] / 100));
                    $(".tax").text('$'.concat(data['tax'] / 100));
                    $(".total").text('$'.concat(data['total'] / 100))
                }
            }
        });
    });
});
