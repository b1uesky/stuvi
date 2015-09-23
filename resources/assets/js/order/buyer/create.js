/**
 * Created by zhenjieruan on 7/1/15.
 */
$(document).ready(function() {

    /**
     * A BEAUTIFUL CARD!
     * https://github.com/jessepollak/card
     */
    //$('#form-payment').card({
    //    // a selector or DOM element for the container
    //    // where you want the card to appear
    //    container: '.card-wrapper', // *required*
    //    width: 350,
    //
    //    formSelectors: {
    //        numberInput: '#payment-number',
    //        nameInput: '#payment-name',
    //        expiryInput: '#payment-month, #payment-year',
    //        cvcInput: '#payment-cvc'
    //    }
    //});

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
                            callback: function(value, validator, $field) {
                                if (value === '') {
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
                                        };
                                    }
                                }
                                if (value.length == 4) {
                                    var min = currentYear;
                                    var max = min + validPeriod;

                                    if (Number(value) < min || Number(value) > max) {
                                        return {
                                            valid: false,
                                            message: 'The year is not valid'
                                        };
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
        .on('err.field.fv', function(e, data) {
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
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
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
            $('<input>').attr({
                type: 'hidden',
                name: 'number',
                value: $('#payment-number').val()
            }).appendTo(this);
            $('<input>').attr({
                type: 'hidden',
                name: 'name',
                value: $('#payment-name').val()
            }).appendTo(this);
            $('<input>').attr({
                type: 'hidden',
                name: 'expire_month',
                value: $('#payment-month').val()
            }).appendTo(this);
            $('<input>').attr({
                type: 'hidden',
                name: 'expire_year',
                value: $('#payment-year').val()
            }).appendTo(this);
            $('<input>').attr({
                type: 'hidden',
                name: 'cvc',
                value: $('#payment-cvc').val()
            }).appendTo(this);

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
