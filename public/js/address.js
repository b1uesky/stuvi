/**
 * Created by zhenjieruan on 7/1/15.
 */
$(document).ready(function () {
    $('.show-addresses').click(function() {
        $('.displayDefaultAddress').hide();
        $('.displayAllAddresses > button').remove('.show_addresses').show(400);
        $('#new-address-panel').show(1000);
        $('.displayAllAddresses').show(1000);
    });

    $('.selectThisAddress').click(function() {
        var address_ID = $(this).prev().find("#address_id").text();
        var address_info = $(this).prev().html();
        $('.displayAllAddresses').hide();
        $('.displayDefaultAddress').find('.address-list').html(address_info);
        $('.displayDefaultAddress').show(1000);
        $('input[name=selected_address_id]').val(address_ID);
        $('#new-address-panel').hide();
    });

    $('#storeAddress').click(function(){
        $('.address-form').submit();
    });

    $('.editThisAddress').click(function() {
        var address_ID = $(this).prev().find("#address_id").text();
        var address_array = [];
        $(this).parent().find('.address').each(function (i, elem) {
            address_array.push($(elem).text());
        });
        $('input[name=addressee]').val(address_array[1]);
        $('input[name=address_line1]').val(address_array[2]);
        $('input[name=address_line2]').val(address_array[3]);
        $('input[name=city]').val(address_array[4].slice(0, -1));
        $('input[name=state_a2]').val(address_array[5]);
        $('input[name=zip]').val(address_array[6]);
        $('input[name=address_id]').val(address_ID);
    });
});
