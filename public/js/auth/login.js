/**
 * Created by Desmond on 7/23/15.
 *
 * FormValidation: http://formvalidation.io/getting-started/
 */

$(document).ready(function () {

    $('.loading').css('visibility', 'hidden');
    // login form validation
    $('#form-login').formValidation({
        framework: 'bootstrap',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
                email: {
                    trigger: 'blur',
                    validators: {
                        notEmpty: {
                            message: 'The Email is required'
                        },
                        blank: {}
                    }
                },
                password: {
                    trigger: 'blur',
                    validators: {
                        notEmpty: {
                            message: 'The password is required'
                        },
                        blank: {}
                    }
                }
            }
    }).on('success.form.fv',function (e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: '/auth/login',
            data: {
                _token: $('[name="csrf_token"]').attr('content'),
                email: $('#login-email').val(),
                password: $('#login-password').val()
            },
            dataType: 'json',
            success: function (response, status) {
                console.log(response);

                // login failed
                if (response.success == false) {
                    $('.alert.alert-danger').remove();
                    $('.loading').css('visibility', 'hidden');

                    for (var field in response.fields) {
                        var error = '<div class="alert alert-danger" role="alert">' +
                            '<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ' +
                            '<span class="sr-only">Error:</span>' + response.fields[field] +
                            '</div>';

                        $(error).insertBefore('#form-login');
                    }
                } else {
                    // success
                    location.reload();
                }


            },
            error: function (xhr, status, errorThrown) {
                console.log(status);
                console.log(errorThrown);
            }
        });
    });

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
                        },
                        blank: {}
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
                        },
                        blank: {}
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
                        },
                        blank: {}
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
                        },
                        blank: {}
                    }
                },
                phone_number: {
                    trigger: 'blur',
                    validators: {
                        notEmpty: {
                            message: 'The phone number is required'
                        },
                        phone: {
                            country: 'US',
                            message: 'The phone number is not valid'
                        },
                        blank: {}
                    }
                },
                university_id: {
                    trigger: 'blur',
                    validators: {
                        notEmpty: {
                            message: 'The university is required'
                        },
                        blank: {}
                    }
                }
            }
        })
        // form submit
        .on('success.form.fv', function (e) {
            e.preventDefault();
            $('.loading').css('visibility', 'visible');

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
                        var validator = 'blank';
                        var message = response.fields[field][0];

                        fv
                            // Show the custom message
                            .updateMessage(field, validator, message)
                            // Set the field as invalid
                            .updateStatus(field, 'INVALID', validator);
                    }
                } else {
                    // success
                    window.location.replace('/user/activate');
                }
            });
        });

    // remove spinner and alert when modal is closed
    $('.spinner-modal').on('hidden.bs.modal', function () {
        $('.loading').css('visibility', 'hidden');
        $('.alert.alert-danger').remove();
    });
});