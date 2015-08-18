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
        $('#new-address-panel').show(1000);
        $('.displayAllAddresses').show(1000);
    });

    $('.selectThisAddress').click(function () {
        var address_ID = $(this).prev().find(".address_id").text();
        var address_info = $(this).prev().html();
        $('.displayAllAddresses').hide();
        $('.displayDefaultAddress').find('.address-list').html(address_info);
        $('.displayDefaultAddress').show(1000);
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
    });

    $('#storeAddedAddress').click(function () {
        $('.add-address-form').submit();
        $('.form-btn').css('visibility', 'hidden');
        $('#add-loading').css('visibility', 'visible');
    });

    $('#storeUpdatedAddress').click(function () {
        $('.update-address-form').submit();
        $('.form-btn').css('visibility', 'hidden');
        $('#update-loading').css('visibility', 'visible');
    });

    $('.editThisAddress').click(function () {
        var address_ID = $(this).parent().find(".address_id").text();
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
                    $('.' + address_ID).hide(1000);
                    if (response['num_of_user_addresses'] < 1) {
                        $('#payment-form').hide(1000);
                        $('.add_new_address').click();
                    }
                }
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
                },
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

            // if payment method is credit card
            if ($('input[name=payment_method]').val() == 'credit_card') {

                // disable place your order button
                $('input[type="submit"]').prop('disabled', true);
            }

            // if payment method is paypal
            if ($('input[name=payment_method]').val() == 'paypal') {

                // disable place your order button
                $('input[type="submit"]').prop('disabled', false);
            }
        })
        .on('success.field.fv', function (e, data) {
            // if payment method is credit card
            if ($('input[name=payment_method]').val() == 'credit_card') {

                // enable place your order button
                $('input[type="submit"]').prop('disabled', false);
            }
        });


    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        var payment_method = $(e.target).text(); // activated tab

        if (payment_method == 'Credit Card') {
            $('input[name=payment_method]').val('credit_card');
        }

        if (payment_method == 'PayPal') {
            $('input[name=payment_method]').val('paypal');
        }
    });

    // disable place your order button by default
    $('input[type="submit"]').prop('disabled', true);

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
        }

        this.submit();
    });
});
