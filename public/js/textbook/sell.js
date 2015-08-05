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
                        remote: {
                            url: '/textbook/validateISBN',
                            data: {
                                _token: $('[name="csrf_token"]').attr('content')
                            },
                            type: 'POST',
                            message: 'The ISBN is not valid'
                        }
                    }
                }
            }
        });
});