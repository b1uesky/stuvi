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
        $('.'+address_ID).append('<button id="change_address" class="btn btn-primary btn-md" onclick="showAllAddress()">Change Address</button>');
        $('.'+address_ID+'> button:first').hide();
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
