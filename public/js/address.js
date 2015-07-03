/**
 * Created by zhenjieruan on 7/1/15.
 */
function showAllAddress(){
    $(document).ready(function(){
            $('div[name=displayAllAddresses]').toggle(1000);
    });
}

function selectAddress(address_ID){
    $(document).ready(function(){
        $('input[name=selected_address_id]').val(address_ID);
    });
}

function storeAddress() {
    $(document).ready(function(){
            var formData = $('#address-form').serialize();
            $.ajax({
                url: '/order/storeAddress',
                data: formData,
                type:"POST",

                success:function(response){
                    $("#address-form").replaceWith(response);
                },

                // Code to run if the request fails; the raw request and
                // status codes are passed to the function
                error: function( xhr, status, errorThrown ) {
                    alert( "Sorry, there was a problem!" );
                    console.log( "Error: " + errorThrown );
                    console.log( "Status: " + status );
                    console.dir( xhr );
                },

                // Code to run regardless of success or failure
                complete: function( xhr, status ) {
                    alert("The request is complete!");
                }

            });

    });


}