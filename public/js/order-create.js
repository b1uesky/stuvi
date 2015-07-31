/**
 * Created by zhenjieruan on 7/1/15.
 */
$(document).ready(function () {

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
    });

    $('#storeUpdatedAddress').click(function () {
        $('.update-address-form').submit();
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
            numberInput: '#stripe-number',
            expiryInput: '#stripe-month, #stripe-year',
            cvcInput: '#stripe-cvc'
        }
    });

    /**
     * Form Validation
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
                stripeNumber: {
                    trigger: 'blur',
                    selector: '#stripe-number',
                    validators: {
                        notEmpty: {
                            message: 'Required'
                        },
                        creditCard: {
                            message: 'The credit card number is not valid'
                        }
                    }
                },
                stripeMonth: {
                    trigger: 'blur',
                    selector: '#stripe-month',
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
                stripeYear: {
                    trigger: 'blur',
                    selector: '#stripe-year',
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
                stripeCvc: {
                    trigger: 'blur',
                    selector: '#stripe-cvc',
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
        })
    /**
     * Stripe Payment
     */
        .on('success.form.fv', function (e) {
            // Prevent default form submission
            e.preventDefault();

            // Get the form element
            var $form = $(e.target);

            // Reset the token first
            $form.find('[name="stripe_token"]').val('');

            var stripePublicKey = $form.find('[name="stripe_public_key"]').val();

            Stripe.setPublishableKey(stripePublicKey);

            Stripe.card.createToken($form, function (status, response) {
                if (response.error) {
                    // Show the error message
                    //bootbox.alert(response.error.message);
                    console.log(response.error.message);
                } else {
                    // Set the token value
                    $form.find('[name="stripe_token"]').val(response.id);

                    // You can submit the form to back-end as usual
                    $form.get(0).submit();

                    // Or using Ajax
                    //$.ajax({
                    //    url: '/path/to/your/back-end/',
                    //    data: $form.serialize(),
                    //    dataType: 'json'
                    //}).success(function(data) {
                    //    // Handle the response
                    //    bootbox.alert(data.message);
                    //
                    //    // Reset the form
                    //    $form.formValidation('resetForm', true);
                    //});
                }
            });
        });
});
