/**
 * Created by Desmond on 7/23/15.
 */

$(document).ready(function () {

    // format phone number
    $("#register-phone").mask("(999)999-9999");

    // Signup form validation
    $('#form-register')
        .formValidation({
            framework: 'bootstrap',
            icon: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                first_name: {
                    trigger: 'blur',
                    validators: {
                        notEmpty: {
                            message: 'The first name is required'
                        },
                        stringLength: {
                            max: 30,
                            message: 'The first name must be less than 30 characters long'
                        },
                        regexp: {
                            regexp: /^[a-zA-Z]+$/,
                            message: 'The first name can only consist of alphabetical'
                        }
                    }
                },
                last_name: {
                    trigger: 'blur',
                    validators: {
                        notEmpty: {
                            message: 'The last name is required'
                        },
                        stringLength: {
                            max: 30,
                            message: 'The last name must be less than 30 characters long'
                        },
                        regexp: {
                            regexp: /^[a-zA-Z]+$/,
                            message: 'The last name can only consist of alphabetical'
                        }
                    }
                },
                email: {
                    trigger: 'blur',
                    validators: {
                        notEmpty: {
                            message: 'The email is required'
                        },
                        remote: {
                            url: '/auth/email',
                            data: {
                                _token: $('[name="csrf_token"]').attr('content')
                            },
                            type: 'POST',
                            message: 'The email address already exsits'
                        }
                        //blank: {} BUG: custom validator does not show up in HTML
                    }
                },
                password: {
                    validators: {
                        notEmpty: {
                            message: 'The password is required'
                        },
                        stringLength: {
                            min: 6,
                            message: 'The password must be at least 6 characters'
                        }
                    }
                },
                phone_number: {
                    validators: {
                        notEmpty: {
                            message: 'The phone number is required'
                        },
                        phone: {
                            country: 'US',
                            message: 'The phone number is not valid'
                        }
                    }
                },
                university_id: {
                    validators: {
                        notEmpty: {
                            message: 'The university is required'
                        }
                    }
                }
            }
        })
        // form submit
        .on('success.form.fv', function (e) {
            e.preventDefault();

            var $form = $(e.target),
                fv = $form.data('formValidation');

            $.ajax({
                type: 'POST',
                url: '/auth/register',
                data: $form.serialize(),
                dataType: 'json'
            }).success(function (response) {
                console.log(response);
                // If there is error returned from server
                if (response.success === false) {
                    for (var field in response.fields) {
                        //console.log(typeof(response.fields[field]));
                        //console.log(response.fields[field]);
                        var validator = '';
                        var message = response.fields[field][0];

                        switch (field) {
                            case 'email':
                                validator = 'emailAddress';
                                break;
                            case 'phone_number':
                                validator = 'phone';
                                break;
                        }

                        fv
                            // Show the custom message
                            .updateMessage(field, validator, message)
                            // Set the field as invalid
                            .updateStatus(field, 'INVALID', validator);
                    }
                } else {
                    // Do whatever you want here
                    // such as showing a modal ...
                    window.location.href = "/home";
                }
            });
        });
});