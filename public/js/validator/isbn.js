/**
 * Created by Desmond on 7/27/15.
 */

$(document).ready(function () {

    $('#form-isbn')
        .formValidation({
            framework: 'bootstrap',
            icon: {
                valid: null,
                invalid: null,
                validating: null
            },
            live: 'disabled',
            fields: {
                isbn: {
                    validators: {
                        notEmpty: {
                            message: 'Please enter your book ISBN'
                        },
                        isbn: {
                            message: 'This is not a valid ISBN',
                            transformer: function($field, validatorName, validator) {
                                return $field.val().replace(/\D/g,'');
                            }
                        }
                    }
                }
            }
        });
});