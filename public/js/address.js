/**
 * Created by zhenjieruan on 7/1/15.
 */
$(document).ready(function () {
    $('.show-addresses').click(function() {
        $('.displayDefaultAddress').hide();
        $('#new-address-panel').show(1000);
        $('.displayAllAddresses').show(1000);
    });

    $('.selectThisAddress').click(function() {
        var address_ID = $(this).prev().find(".address_id").text();
        var address_info = $(this).prev().html();
        $('.displayAllAddresses').hide();
        $('.displayDefaultAddress').find('.address-list').html(address_info);
        $('.displayDefaultAddress').show(1000);
        $.ajax({
            url : "/address/select",
            data:{
                _token: $('[name="csrf_token"]').attr('content'),
                selected_address_id:address_ID
            },
            type:'POST',
            success:function(response){
                if(response['set_as_default']){
                    $('input[name=selected_address_id]').val(address_ID);
                }
            }
        });
        $('#new-address-panel').hide();
    });

    $('#storeAddedAddress').click(function(){
        $('.add-address-form').submit();
    });

    $('#storeUpdatedAddress').click(function(){
        $('.update-address-form').submit();
    });

    $('.editThisAddress').click(function() {
        var address_ID = $(this).parent().find(".address_id").text();
        var address_array = [];
        $(this).parent().find('.address').each(function (i, elem) {
            address_array.push($(elem).text());
        });
        $('input[name=addressee]').val(address_array[1]);
        $('input[name=address_line1]').val(address_array[2]);
        $('input[name=address_line2]').val(address_array[3]);
        $('input[name=city]').val(address_array[4]);
        $('input[name=state_a2]').val(address_array[5]);
        $('input[name=zip]').val(address_array[6]);
        $('input[name=address_id]').val(address_ID);
    });

    $('.deleteThisAddress').click(function(){
        var address_ID = $(this).parent().find(".address_id").text();
        $.ajax({
            url: '/address/delete',

            data:{
                _token: $('[name="csrf_token"]').attr('content'),
                address_id : address_ID
            },

            type:"POST",

            success:function(response){
                if(response['is_deleted'] === true){
                    $('.'+address_ID).hide(1000);
                    if(response['num_of_user_addresses'] < 1){
                        $('#payment-form').hide(1000);
                        $('.add_new_address').click();
                    }
                }
            }
        });
    });

    $('#card-input').keyup(function () {
        var num = $(this).val().split("-").join("");
        num = num.match(new RegExp('.{1,4}', 'g')).join("-");
        $(this).val(num);
    });
});
