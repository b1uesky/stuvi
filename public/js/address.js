/**
 * Created by zhenjieruan on 7/1/15.
 */
function showAllAddress(){
    $(document).ready(function(){
        $('.displayDefaultAddress').hide();
        $('.displayAllAddresses > button').remove('#change_address').show(400);
        $('.add_new_address').show(1000);
        $('.displayAllAddresses').show(1000);
    });
}

function selectAddress(address_ID){
    $(document).ready(function(){
        $('.displayAllAddresses').hide();
        $('.'+address_ID+' button').hide();
        $('.'+address_ID).append('<button id="change_address" class="btn btn-primary btn-md" onclick="showAllAddress()">Change Address</button>');
        $('.add_new_address').hide();
        $('.'+address_ID).show(1000);
        $('input[name=selected_address_id]').val(address_ID);
    });
}

function storeAddress() {
    $(document).ready(function () {
        $('.address-form').submit();
    });
}

function editAddress(address_ID){
    $(document).ready(function(){
        var address_array = [];
        $('.'+address_ID+' ul li').each(function(i, elem) {
            address_array.push($(elem).text());
        });
        $('input[name=addressee]').val(address_array[0]);
        $('input[name=address_line1]').val(address_array[1]);
        $('input[name=address_line2]').val(address_array[2]);
        $('input[name=city]').val(address_array[3]);
        $('input[name=state_a2]').val(address_array[4]);
        $('input[name=zip]').val(address_array[5]);
        $('input[name=address_id]').val(address_ID);
    });
}
