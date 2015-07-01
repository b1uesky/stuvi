/**
 * Created by zhenjieruan on 7/1/15.
 */
function selectAddress(address_ID) {
    $.ajax({
        //url for the request
        url: '/order/storeAddress',
        data: {
            id: address_ID
        },
        type: "GET",
        dataType: "json",

        //function to run if request success
        success: function(address_array){
            $('input[name=selected_address_id]').val(address_ID);
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
}