/**
 * Created by zhenjieruan on 7/1/15.
 */
$(document).ready(function () {

    $('#update-loading').css('visibility', 'hidden');
    $('#add-loading').css('visibility', 'hidden');

    /**
     * Shipping Address
     */
    $('.show-addresses').click(function () {
        $('.displayDefaultAddress').hide();
        $('#new-address-panel').slideDown(500);
        $('.displayAllAddresses').slideDown();
    });

    //select address
    $('.all-addresses-list').click(function () {
        var $this = $(this)
        var address_ID = $this.find(".address_id").text();
        var address_info = $this.html();
        $('.displayAllAddresses').hide();
        $('.displayDefaultAddress').find('.address-list').html(address_info);
        $('.displayDefaultAddress').fadeIn(500);
        $.ajax({
            url: "/address/select",
            data: {
                _token: $('[name="csrf_token"]').attr('content'),
                selected_address_id: address_ID
            },
            type: 'POST',
            success: function (response) {
                if (response['set_as_default']) {
                    $('input[name=selected_address_id]').val(address_ID);
                }
            }
        });
        $('#new-address-panel').hide();
        $('#loader-wrapper').hide();
    });

    // $('#storeAddedAddress').click(function () {
    //     $('#add-address-form').submit();
    // });

    $('#storeAddedAddress').click(function(e){
        e.preventDefault();
        var $form = $(this).parents().find('#add-address-form');
        $.ajax({
            type : 'POST',
            url: '/address/store',
            data: {
                _token : $('[name="csrf_token"]').attr('content'),
                addressee : $form.find("input[name=addressee]").val(),
                address_line1 : $form.find("input[name=address_line1]").val(),
                address_line2 : $form.find("input[name=address_line2]").val(),
                city : $form.find("input[name=city]").val(),
                state_a2 : $form.find("input[name=state_a2]").val(),
                zip : $form.find("input[name=zip]").val(),
                phone_number : $form.find("input[name=phone_number]").val()
            },
            success: function(data,status){
                if(data['success']){
                    var address = data['address']
                    var address_panel = $('<div class="thumbnail col-md-8 displayAllAddresses '+address['id']+'">'+
                        '<div class="panel-body">'+
                        '<button type="button" class="close deleteThisAddress" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                            '<button class="btn btn-default primary-btn address-btn editThisAddress">'+
                                'Edit'+
                            '</button>'+
                        '</div>'+
                    '</div>');
                    var address_list = $('#default-address-list').clone();
                    address_list.removeAttr('id');
                    address_list.attr('class','address-list all-addresses-list');
                    address_list.prepend('<li class="address address_id">'+address['id']+'</li>')
                    address_list.find('.addresse').text(address['addressee']);
                    address_list.find('.address_line1').text(address['address_line1']);
                    address_list.find('.address_line2').text(address['address_line2']);
                    address_list.find('.city').text(address['city']);
                    address_list.find('.state_a2').text(address['state_a2']);
                    address_list.find('.zip').text(address['zip']);
                    address_list.find('.phone').text(address['phone_number']);
                    address_list.insertBefore(address_panel.find('.editThisAddress'));
                    address_panel.insertBefore($('#new-address-panel'));
                    var address_info = address_list.html();
                    $('.displayDefaultAddress').find('.address-list').html(address_info);
                    $('.displayAllAddresses').hide();
                    $('#new-address-panel').hide();
                    $('.displayDefaultAddress').fadeIn(500);
                    $('#paymentDiv').fadeIn(100);
                    $('#add-address-modal').modal('hide');
                    location.reload();
                }
            },
            error: function (xhr, status, errorThrown) {
                console.log(status);
                console.log(errorThrown);
            }
        });
    });

    $('#storeUpdatedAddress').click(function () {
        $('#update-address-form').submit();
    });

    $('.editThisAddress').click(function(){
        var $this = $(this);
        var address_ID = $(this).parent().find(".address_id").text();
        $.ajax({
            type: 'GET',
            url: '/address/show',
            data: {
                _token: $('[name="csrf_token"]').attr('content'),
                address_id: address_ID
            },
            dataType: 'json',
            success: function (data, status) {
                var address = data["address"];
                $('#update-address-modal').find('input[name=addressee]').val(address['addressee']);
                $('#update-address-modal').find('input[name=address_line1]').val(address['address_line1']);
                $('#update-address-modal').find('input[name=address_line2]').val(address['address_line2']);
                $('#update-address-modal').find('input[name=city]').val(address['city']);
                $('#update-address-modal').find('input[name=state_a2]').val(address['state_a2']);
                $('#update-address-modal').find('input[name=zip]').val(address['zip']);
                $('#update-address-modal').find('input[name=phone_number]').val(address['phone_number']);
                $('#update-address-modal').find('input[name=address_id]').val(address_ID);
                $('#update-address-modal').modal('show');
            },
            error: function (xhr, status, errorThrown) {
                console.log(status);
                console.log(errorThrown);
            }
        });
    });

    $("#new-address-panel").on('click',function(){
        $('#add-address-modal').modal('show');
    });

    $('.deleteThisAddress').click(function () {
        var address_ID = $(this).parent().find(".address_id").text();
        $.ajax({
            url: '/address/delete',

            data: {
                _token: $('[name="csrf_token"]').attr('content'),
                address_id: address_ID
            },

            type: "POST",

            success: function (response) {
                if (response['is_deleted'] === true) {
                    $('.' + address_ID).fadeOut(100).remove();
                    if (response['num_of_user_addresses'] < 1) {
                        $('#paymentDiv').fadeOut(100);
                        $('#new-address-panel').click();
                    }
                }
                $('#loader-wrapper').hide();
            }
        });
    });

    /**
     * A BEAUTIFUL CARD!
     * https://github.com/jessepollak/card
     */
    $('#form-payment').card({
        // a selector or DOM element for the container
        // where you want the card to appear
        container: '.card-wrapper', // *required*
        width: 350,

        formSelectors: {
            numberInput: '#payment-number',
            nameInput: '#payment-name',
            expiryInput: '#payment-month, #payment-year',
            cvcInput: '#payment-cvc'
        }
    });

    /**
     * Form Validation for credit card
     */
    //var formValidation = $('#form-payment').data('formValidation');

    $('#form-payment').
        formValidation({
            framework: 'bootstrap',
            icon: {
                valid: null,
                invalid: null,
                validating: null
            },
            fields: {
                paymentNumber: {
                    trigger: 'blur',
                    selector: '#payment-number',
                    validators: {
                        notEmpty: {
                            message: 'Required'
                        },
                        creditCard: {
                            message: 'The credit card number is not valid'
                        }
                    }
                },
                paymentName: {
                    trigger: 'blur',
                    selector: '#payment-name',
                    validators: {
                        notEmpty: {
                            message: 'Required'
                        },
                        regexp: {
                            regexp: /^[a-z\s]+$/i,
                            message: 'The full name can consist of alphabetical characters and spaces only'
                        }
                    }
                },
                paymentMonth: {
                    trigger: 'blur',
                    selector: '#payment-month',
                    validators: {
                        notEmpty: {
                            message: 'Required'
                        },
                        regexp: {
                            regexp: /^(0[1-9]|1[0-2])$/,
                            message: 'The month must between 01 and 12'
                        }
                    }
                },
                paymentYear: {
                    trigger: 'blur',
                    selector: '#payment-year',
                    validators: {
                        callback: {
                            message: 'The year is not valid',
                            callback: function (value, validator, $field) {
                                if (value == '') {
                                    return {
                                        valid: false,
                                        message: 'Required'
                                    };
                                }

                                if (value.length != 2 && value.length != 4) {
                                    return {
                                        valid: false,
                                        message: 'The year must be 2 or 4 digits'
                                    };
                                }

                                var currentYear = new Date().getFullYear();
                                var validPeriod = 20;

                                if (value.length == 2) {
                                    var min = Number(currentYear.toString().slice(2, 4));
                                    var max = min + validPeriod;

                                    if (Number(value) < min || Number(value) > max) {
                                        return {
                                            valid: false,
                                            message: 'The year is not valid'
                                        }
                                    }
                                }
                                if (value.length == 4) {
                                    var min = currentYear;
                                    var max = min + validPeriod;

                                    if (Number(value) < min || Number(value) > max) {
                                        return {
                                            valid: false,
                                            message: 'The year is not valid'
                                        }
                                    }
                                }

                                return true;
                            }
                        }
                    }
                },
                paymentCvc: {
                    trigger: 'blur',
                    selector: '#payment-cvc',
                    validators: {
                        notEmpty: {
                            message: 'Required'
                        },
                        cvv: {}
                    }
                }
            }
        })
        .on('err.field.fv', function (e, data) {
            // $(e.target)  --> The field element
            // data.fv      --> The FormValidation instance
            // data.field   --> The field name
            // data.element --> The field element

            // Hide the messages
            data.element
                .data('fv.messages')
                .find('.help-block[data-fv-for="' + data.field + '"]').hide();
        });


    // on payment methods tab switch
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        var payment_method = $(e.target).text(); // activated tab

        if (payment_method == 'Credit Card') {
            $('input[name=payment_method]').val('credit_card');
        }

        if (payment_method == 'PayPal') {
            $('input[name=payment_method]').val('paypal');
        }
    });


    $('#form-place-order').submit(function(e) {
        e.preventDefault();

        var payment_method = $('input[name=payment_method]').val();

        // add additional input fields if pay by credit card
        if (payment_method == 'credit_card') {
            $('<input>').attr({type: 'hidden', name: 'number', value: $('#payment-number').val()}).appendTo(this);
            $('<input>').attr({type: 'hidden', name: 'name', value: $('#payment-name').val()}).appendTo(this);
            $('<input>').attr({type: 'hidden', name: 'expire_month', value: $('#payment-month').val()}).appendTo(this);
            $('<input>').attr({type: 'hidden', name: 'expire_year', value: $('#payment-year').val()}).appendTo(this);
            $('<input>').attr({type: 'hidden', name: 'cvc', value: $('#payment-cvc').val()}).appendTo(this);

            // validate form
            $('#form-payment').formValidation('validate');
            var isValidForm = $('#form-payment').data('formValidation').isValid();

            if (isValidForm) {
                this.submit();
            }
        }

        if (payment_method == 'paypal') {
            this.submit();
        }

    });
});
