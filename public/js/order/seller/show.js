/**
 * Created by nlouie on 6/16/15.
 */

$(document).ready(function () {
    // Date time picker
    // http://xdsoft.net/jqplugins/datetimepicker/
    $('#datetimepicker').datetimepicker({
        format: 'Y-m-d G:i', // config/app datetime_format
        minDate: '-1970/01/01',//yesterday is minimum date(for today use 0 or -1970/01/01)
        maxDate: '+1970/01/02', // must schedule within 1 day
        minTime: '9:00',
        maxTime: '19:00',
        //mask:true, // '9999/19/39 29:59' - digit is the maximum possible for a cell
        lang: 'en',
        step: 30
    });

    // Ajax: schedule pickup time
    $('#schedule-pickup-time').submit(function (e) {
        e.preventDefault();

        $.ajax({
            type: 'POST',
            url: '/order/seller/schedulePickupTime',
            data: {
                _token: $('[name="csrf_token"]').attr('content'),
                seller_order_id: $('input[name=seller_order_id]').val(),
                scheduled_pickup_time: $('#datetimepicker').val()
            },
            dataType: 'json',
            success: function (data, status) {
                $('.text-scheduled-pickup-time').text('Scheduled pickup time: ' + data['scheduled_pickup_time']);
            },
            error: function (xhr, status, errorThrown) {
                console.log(status);
                console.log(errorThrown);
            },
            complete: function (xhr, status) {
                //alert('complete!');
            }
        });
    });

    $('.btn-change-address').click(function () {
        toggleAddress();
    });

    // Ajax: update seller default address
    $('.form-update-default-address').submit(function (e) {
        e.preventDefault();
        var $this = $(this);
        var seller_order_id = $('input[name=seller_order_id]').val();
        var selected_address_id = $this.find('input[name=address_id]').val();

        $.ajax({
            type: 'GET',
            url: '/order/seller/assignAddress',
            data:{
                selected_address_id: selected_address_id,
                seller_order_id : seller_order_id
            },
            dataType: 'json',
            success: function(data,status){
            },
            error: function (xhr, status, errorThrown) {
                console.log(status);
                console.log(errorThrown);
            }
        });

        $.ajax({
            type: 'POST',
            url: '/address/select',
            data: {
                _token: $('[name="csrf_token"]').attr('content'),
                selected_address_id: selected_address_id
            },
            dataType: 'json',
            success: function (data, status) {
                //console.log(data['address']);
                $this = $this.parents().find('.address-list');
                var address = {};
                address['addressee'] = $.trim($this.find('.seller-address-addressee').text());
                address['address-line'] = $.trim($this.find('.seller-address-address-line').text());
                address['city'] = $.trim($this.find('.seller-address-city').text());
                address['state'] = $.trim($this.find('.seller-address-state').text());
                address['zip'] = $.trim($this.find('.seller-address-zip').text());

                updateAddress($(".seller-address"), address);

                toggleAddress();
            },
            error: function (xhr, status, errorThrown) {
                console.log(status);
                console.log(errorThrown);
            }
        });
    });

    // Ajax: edit seller address
    $('.form-edit-address').submit(function (e) {
        e.preventDefault();
        var $this = $(this);

        $.ajax({
            type: 'GET',
            url: '/address/show',
            data: {
                _token: $('[name="csrf_token"]').attr('content'),
                address_id: $this.find('input[name=address_id]').val()
            },
            dataType: 'json',
            success: function (data, status) {
                var address = data["address"];
                updateAddress($("#seller-address-form"),address);
                $("delete-address").show();
                $("#address-form-modal").modal("show");
            },
            error: function (xhr, status, errorThrown) {
                console.log(status);
                console.log(errorThrown);
            }
        });
    });

    $("#delete-address").click(function(e){
        e.preventDefault();
        var $this = $(this);
        var address_id = $this.parents().find('input[name=address_id]').val();
        var address_panel = $(".form-update-default-address").find("input[value="+address_id+"]").parent();

        $.ajax({
            type: "POST",
            url: "/address/delete",
            data:{
                _token: $('[name="csrf_token"]').attr('content'),
                address_id : address_id
            },
            dataType: 'json',
            success: function (data, status){
                if(data['is_deleted']){
                    address_panel.parent().remove();
                    $("#address-form-modal").modal("hide");
                }
            }

        });
    });

    $(".add-address-btn").click(function(e){
        e.preventDefault();
        $("#delete-address").hide();
        $("#address-form-modal").modal("show");
    });

    $('#submit-address-form').click(function(e){
        e.preventDefault();
        var $form = $('#seller-address-form');
        var seller_order_id = $('input[name=seller_order_id]').val();
        var address_id = $form.find('input[name=address_id]').val();

        $.ajax({
            type: 'POST',
            url: address_id ? '/address/update' : '/address/store',
            data: {
                _token : $('[name="csrf_token"]').attr('content'),
                address_id : address_id,
                addressee : $form.find("input[name=addressee]").val(),
                address_line1 : $form.find("input[name=address_line1]").val(),
                address_line2 : $form.find("input[name=address_line2]").val(),
                city : $form.find("input[name=city]").val(),
                state_a2 : $form.find("input[name=state_a2]").val(),
                zip : $form.find("input[name=zip]").val(),
                phone_number : $form.find("input[name=phone_number]").val()
            },
            success: function (data,status){
                var address= data["address"];
                address_id = address["id"];
                if(address["address_line2"]) {
                    address["address-line"] = address["address_line1"] + " " + address["address_line2"];
                }else{
                    address["address-line"] = address["address_line1"];
                }
                $.ajax({
                    type: 'GET',
                    url: '/order/seller/assignAddress',
                    data:{
                        selected_address_id: address_id,
                        seller_order_id : seller_order_id
                    },
                    dataType: 'json',
                    success: function(data,status){
                    },
                    error: function (xhr, status, errorThrown) {
                        console.log(status);
                        console.log(errorThrown);
                    }
                });
                updateAddress($(".seller-address"),address);
                toggleAddress();
                $("#address-form-modal").modal("hide");
            }
        });
    });

    /**
     * Update the address of a specific ul.
     *
     * @param address
     */
    function updateAddress($this/*the address list need to be update*/, address) {
        if ($this.is("form")) {
            $this.find("input[name=addressee]").val(address["addressee"]);
            $this.find("input[name=address_id]").val(address["id"]);
            $this.find("input[name=address_line1]").val(address["address_line1"]);
            $this.find("input[name=address_line2]").val(address["address_line2"]);
            $this.find("input[name=city]").val(address["city"]);
            $this.find("input[name=state_a2]").val(address["state_a2"] ? address["state_a2"] : address["state_name"]);
            $this.find("input[name=zip]").val(address["zip"]);
            $this.find("input[name=phone_number]").val(address["phone_number"]);
        } else {
            $this.find(".seller-address-addressee").text($.trim(address["addressee"]));
            $this.find(".seller-address-address-line").text($.trim(address["address-line"]));
            $this.find(".seller-address-city").text($.trim(address["city"]));
            $this.find(".seller-address-state").text($.trim(address["state"]));
            $this.find(".seller-address-zip").text($.trim(address["zip"]));
        }
    }

    /**
     * Toggle between default address and address book.
     */
    function toggleAddress() {
        $('.seller-address').toggle();
        $('.seller-address-book').slideToggle();

        // toggle button text
        if ($('.btn-change-address').text() == 'Change') {
            $('.btn-change-address').text('Cancel');
        } else {
            $('.btn-change-address').text('Change');
        }
    }
});

function setFocusToTextBox() {
    document.getElementById("datetimepicker").focus();
}